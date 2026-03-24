<?php
session_start();
require_once 'db-conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

if (isset($_POST['login'])) {
    $email = $_POST['emailLogin'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = $cnnPDO->prepare('SELECT * FROM usuarios WHERE correo = :correo AND password = :password');
        $sql->bindParam(':correo', $email);
        $sql->bindParam(':password', $password);

        $sql->execute();

        if ($sql->rowCount()) {
            $campos = $sql->fetch();

            if ($campos['correo'] == "admin@admin") {
                $_SESSION['nombre'] = $campos['nombre'];
                header('location: vista-admin.php');
            } else {
                $_SESSION['idUsuario'] = $campos['id'];
                $_SESSION['nombre'] = $campos['nombre'];
                $_SESSION['correo'] = $campos['correo'];
                $_SESSION['foto'] = unserialize($campos['foto']);

                header('location: index.php');
            }
        } else {
        }
    }
}

if (isset($_POST['registrar'])) {
    $id = uniqid();
    $nombre = $_POST['nombre'];
    $correo = $_POST['emailReg'];
    $password = $_POST['passwordReg'];
    $foto = serialize('perfil.png');

    $query = $cnnPDO->prepare('SELECT correo from usuarios WHERE correo = :correo');
    $query->bindParam(':correo', $correo);
    $query->execute();

    $count = $query->rowCount();

    if ($count) {
        //mostrarAlerta('El usuario ya esta registrado.');
    } else {
        $sql = $cnnPDO->prepare("INSERT INTO usuarios
            (id, nombre, correo, password, foto) VALUES (:id, :nombre, :correo, :password, :foto)");

        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':correo', $correo);
        $sql->bindParam(':password', $password);
        $sql->bindParam(':foto', $foto);

        $sql->execute();

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
        $mail->addAddress($correo); // Cambia esto al destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Te has registrado correctamente!'; // Asunto del correo

        $body = '<html>
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
                            <h1>¡Bienvenido a UTC Market, ' . $nombre . '!</h1>
                            <p>Te damos la bienvenida a la plataforma de compras en linea de la UTC.</p>
                            <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en ponerte en contacto con nuestro equipo de soporte.</p>
                            <p>Esperamos que disfrutes de tu experiencia de compra!</p>
                            <p class="note">Este es un mensaje automatico, por favor no responda a este correo.</p>
                        </div>
                    </body>
                    </html>';

        $mail->Body = $body;

        try {
            $mail->send();
        } catch (Exception $e) {
        }

        header('location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro / Login</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <nav class="shadow p-5 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <div class="d-flex gap-5">
                <a href="index.php">Volver al Inicio</a>
            </div>
        </div>
    </nav>

    <?php
    if (!empty($_GET['sesion'])) {
    ?>
        <p class="text-center mb-3" style="font-size: 23px;">Inicia Sesion o Registrate primero.</p>
    <?php
    }
    ?>

    <div class="row">
        <div class="col">
            <div class="shadow caja-sesion p-5">
                <form method="post" class="d-flex flex-column gap-3">
                    <h3>Inicia Sesion</h3>
                    <div>
                        <label for="emailLogin">Correo Electronico</label>
                        <input type="email" name="emailLogin" id="emailLogin" class="form-control">
                    </div>
                    <div>
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button class="btn btn-primary" name="login">Aceptar</button>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="shadow caja-sesion p-5 mt-5">
                <form method="post" class="d-flex flex-column gap-3">
                    <h3>Registrate</h3>
                    <div>
                        <label for="nombre">Nombre</label>
                        <input type="name" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div>
                        <label for="correoReg">Correo Electronico</label>
                        <input type="email" name="emailReg" id="correoReg" class="form-control">
                    </div>
                    <div>
                        <label for="passwordReg">Contraseña</label>
                        <input type="password" name="passwordReg" id="passwordReg" class="form-control">
                    </div>
                    <button class="btn btn-primary" name="registrar">Aceptar</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="mt-5" style="background-color: black; color: white; padding: 20px 0;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 style="color: white;">Contactanos</h4>
                    <p style="color: white;">Dirección: Av. Industria Metalúrgica No. 2001, Ramos Arizpe, Mexico</p>
                    <p style="color: white;">Teléfono: +1 844-288-3800</p>
                </div>
                <div class="col-md-6">
                    <h4 style="color: white;">Síguenos</h4>
                    <a href="https://www.facebook.com/UniversidadTecnologicadeCoahuila/?locale=es_LA" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <!-- Ícono de Instagram -->
                    <a href="https://www.instagram.com/utcoahuila/" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</body>

</html>