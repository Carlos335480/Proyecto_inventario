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

    if (!$count) {
        $sql = $cnnPDO->prepare("INSERT INTO usuarios (id, nombre, correo, password, foto) VALUES (:id, :nombre, :correo, :password, :foto)");

        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':correo', $correo);
        $sql->bindParam(':password', $password);
        $sql->bindParam(':foto', $foto);

        $sql->execute();

        // PHPMailer logic...
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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

    <?php if (!empty($_GET['sesion'])) { ?>
        <p class="text-center mb-3 text-warning animar-fade-up" style="font-size: 23px;">Inicia Sesión o Regístrate primero.</p>
    <?php } ?>

    <div class="container mt-5">
        <div class="row gap-5 justify-content-center">
            <div class="col-md-5">
                <div class="shadow caja-sesion p-5 animar-fade-up w-100 m-0">
                    <form method="post" class="d-flex flex-column gap-3">
                        <h3 class="text-info">Inicia Sesión</h3>
                        <div>
                            <label for="emailLogin">Correo Electrónico</label>
                            <input type="email" name="emailLogin" id="emailLogin" class="form-control" required>
                        </div>
                        <div>
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button class="btn btn-outline-info mt-3" name="login">Aceptar</button>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="shadow caja-sesion p-5 animar-fade-up w-100 m-0">
                    <form method="post" class="d-flex flex-column gap-3">
                        <h3 class="text-info">Regístrate</h3>
                        <div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                        </div>
                        <div>
                            <label for="correoReg">Correo Electrónico</label>
                            <input type="email" name="emailReg" id="correoReg" class="form-control" required>
                        </div>
                        <div>
                            <label for="passwordReg">Contraseña</label>
                            <input type="password" name="passwordReg" id="passwordReg" class="form-control" required>
                        </div>
                        <button class="btn btn-outline-info mt-3" name="registrar">Aceptar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5" style="padding: 20px 0;">
        <div class="container animar-fade-up">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-info">Contactanos</h4>
                    <p>Dirección: Av. Industria Metalúrgica No. 2001, Ramos Arizpe, Mexico</p>
                    <p>Teléfono: +1 844-288-3800</p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-info">Síguenos</h4>
                    <a href="#" class="text-light fs-4 me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-light fs-4"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="animaciones.js"></script>
</body>
</html>