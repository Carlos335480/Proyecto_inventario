<?php
session_start();
require_once 'db-conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$sql = $cnnPDO->prepare('SELECT * FROM productos WHERE idproducto = :id');
$sql->bindParam(':id', $_GET['id']);
$sql->execute();

$campos = $sql->fetch();
unset($sql);
$fotos = unserialize($campos["fotos"]);
$mail = new PHPMailer(true);

if (isset($_POST['pagar'])) {
    if (!empty($_POST['direccion']) && !empty($_POST['titular']) && !empty($_POST['tarjeta']) && !empty($_POST['vencimiento']) && !empty($_POST['cvv'])) {
        $idCompra = uniqid();
        $direccion = $_POST['direccion'];
        $titular = $_POST['titular'];
        $tarjeta = $_POST['tarjeta'];
        $fechaActual = date('Y-m-d H:i:s');

        // Insertar todos los juegos en la tabla 'compras'
        $sql = $cnnPDO->prepare("INSERT INTO compras (idcompra, idcomprador, idvendedor, producto, comprador, precio, vendedor, fecha, domicilio, tarjeta, titular) 
            VALUES (:idcompra, :idcomprador, :idvendedor, :producto, :comprador, :precio, :vendedor, :fecha, :domicilio, :tarjeta, :titular)");
        $sql->bindParam(':idcompra', $idCompra);
        $sql->bindParam(':idcomprador', $_SESSION['idUsuario']);
        $sql->bindParam(':idvendedor', $campos['idvendedor']);
        $sql->bindParam(':producto', $campos['titulo']);
        $sql->bindParam(':comprador', $_SESSION['nombre']);
        $sql->bindParam(':precio', $campos['precio']);
        $sql->bindParam(':vendedor', $campos['vendedor']);
        $sql->bindParam(':fecha', $fechaActual);
        $sql->bindParam(':domicilio', $direccion);
        $sql->bindParam(':tarjeta', $tarjeta);
        $sql->bindParam(':titular', $titular);

        $sql->execute();

        // Enviar Correo
        $emailcontacto = $_SESSION['correo'];

        // Configuración de PHPMailer
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '22040042@alumno.utc.edu.mx'; // Tu correo electrónico de Gmail
        $mail->Password = 'Esekatete1.'; // Tu contraseña de correo electrónico
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('22040042@alumno.utc.edu.mx', 'Mercado UTC'); // Cambia esto a tu dirección de correo y nombre
        $mail->addAddress("$emailcontacto"); // Cambia esto al destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Tu compra se ha realizado!'; // Asunto del correo

        $body = '
                <html>
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f4f4f4;
                            padding: 20px;
                        }
                        .container {
                            max-width: 600px;
                            margin: 0 auto;
                            background-color: #fff;
                            padding: 20px;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        h1 {
                            color: #007bff;
                        }
                        p {
                            color: #333;
                            line-height: 1.6;
                        }
                        .note {
                            font-size: 0.8em;
                            color: #888;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Tu pedido ha sido realizado!</h1>
                        <p>Gracias por comprar en UTC Market! Tu pedido ya se encuentra en camino.</p>
                        <p>Si tu pedido no llega en menos de 30 minutos, se te devolvera tu dinero.</p>
                        <p class="note">Este es un mensaje automatico, por favor no responda a este correo.</p>
                    </div>
                </body>
                </html>
            ';

        $mail->Body = $body;

        try {
            $mail->send();
        } catch (Exception $e) {
            echo 'Ocurrió un error al enviar el correo: ' . $mail->ErrorInfo;
        }

        header('location: compra-exitosa.html');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Mercado UTC</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
</head>
<body>
    <nav class="shadow p-5 mb-4 animar-fade-in visible">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <div class="d-flex gap-5">
                <a href="index.php">Volver al Inicio</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row animar-fade-up">
            <div class="col-md-6 text-center">
                <h3 class="display-5 text-info mb-4">Producto a Pagar</h3>
                <img src='imagenes/<?php echo "$fotos[0]"; ?>' class="rounded shadow" style="width: 100%; height: auto; max-height: 60vh; object-fit: cover;">
            </div>
            <div class="col-md-6 p-4">
                <div class="caja-sesion w-100 m-0 p-5 shadow">
                    <h3 class="display-6 text-center text-info mb-4">Detalles de Pago</h3>
                    <form method="post">
                        <div class="form-group mb-3">
                            <label for="lugarEntrega" class="text-light">Lugar de Entrega</label>
                            <select class="form-control" id="lugarEntrega" name="direccion">
                                <option value="Edificio 1">Edificio 1</option>
                                <option value="Edificio 2">Edificio 2</option>
                                <option value="Edificio 3">Edificio 3</option>
                                <option value="Edificio 4">Edificio 4</option>
                                <option value="Dona Keka">Doña Keka</option>
                                <option value="Cafeteria">Cafetería</option>
                                <option value="Burritos Benja">Burritos Benja</option>
                            </select>
                        </div>

                        <h4 class="mt-4 mb-3 text-info">Datos de Tarjeta</h4>
                        <div class="form-group mb-3">
                            <label for="numeroTarjeta" class="text-light">Número de Tarjeta</label>
                            <input type="text" class="form-control" id="tarjeta" name="tarjeta" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nombreTitular" class="text-light">Nombre del Titular</label>
                            <input type="text" class="form-control" id="titular" name="titular" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group">
                                    <label for="fechaVencimiento" class="text-light">Vencimiento</label>
                                    <input type="text" class="form-control" id="vencimiento" name="vencimiento" placeholder="MM/AA" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="cvv" class="text-light">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-success w-100 fs-5" name="pagar">Completar Pago</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="animaciones.js"></script>
</body>
</html>