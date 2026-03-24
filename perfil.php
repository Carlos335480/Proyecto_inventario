<?php
session_start();
require_once 'db-conexion.php';

$sql = $cnnPDO->prepare('SELECT foto FROM usuarios WHERE id = :id');
$sql->bindParam(':id', $_SESSION['idUsuario']);

$sql->execute();
$campo = $sql->fetch();

if (empty($_SESSION['nombre'])) {
    header('location: index.php');
}

if (isset($_POST['editar'])) {
    $id = $_SESSION['idUsuario'];

    $query = $cnnPDO->prepare('SELECT * FROM usuarios WHERE id = :id');
    $query->bindParam(':id', $id);
    $query->execute();
    $campo = $query->fetch();

    if (empty($_POST['nombre'])) {
        $nombre = $campo['nombre'];
    } else {
        $nombre = $_POST['nombre'];
        $_SESSION['nombre'] = $nombre;
    }

    if (empty($_POST['correo'])) {
        $correo = $campo['correo'];
    } else {
        $correo = $_POST['correo'];
        $_SESSION['correo'] = $correo;
    }

    if (empty($_POST['password'])) {
        $password = $campo['password'];
    } else {
        $password = $_POST['password'];
        $_SESSION['password'] = $password;
    }

    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $foto = $_FILES["foto"];
        $foto_nombre = $foto["name"];
        move_uploaded_file($foto["tmp_name"], "imagenes/" . $foto_nombre);
        $_SESSION['foto'] = $foto_nombre;
    } else {
        $foto_nombre = $_SESSION['foto'];
    }


    $sql = $cnnPDO->prepare("UPDATE usuarios
        SET nombre = :nombre, correo = :correo, password = :password, foto = :foto WHERE id = :id");

    $sql->bindParam(':nombre', $nombre);
    $sql->bindParam(':correo', $correo);
    $sql->bindParam(':password', $password);
    $sql->bindValue(':foto', serialize($foto_nombre));
    $sql->bindParam(':id', $id);

    $sql->execute();
    unset($sql);
    unset($cnnPDO);

    header('location: perfil.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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

    <div class="row">
        <div class="col-5 p-5">
            <div class="shadow p-4 d-flex flex-column gap-4">
                <div class="d-flex gap-4">
                    <img src='imagenes/<?php echo unserialize($campo['foto']); ?>' alt="Foto de perfil" class="rounded-circle" style="width: 10vw; margin: 2rem 0 1rem 0;">
                    <p class="display-6 mt-5"><?php echo $_SESSION['nombre']; ?></p>
                </div>
                <div class="d-flex flex-column gap-3">
                    <h4>Correo Electronico</h4>
                    <p style="font-size: 17px;"><?php echo $_SESSION['correo']; ?></p>
                </div>
                <div class="d-flex flex-column gap-3">
                    <h4>id</h4>
                    <p style="font-size: 17px;"><?php echo $_SESSION['idUsuario']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-7 p-5">
            <form method="post" enctype="multipart/form-data" class="shadow p-4">
                <p class="display-6" style="font-size: 40px;">Edita tu perfil</p>
                <p>Modifica solo lo que desees cambiar</p>
                <hr>
                <input name="nombre" class="form-control" type="text" placeholder="Nombre" aria-label="default input example" style="margin-bottom: 20px;">
                <input name="correo" class="form-control" type="email" placeholder="Correo" aria-label="default input example" style="margin-bottom: 20px;">
                <input name="password" class="form-control" type="password" placeholder="Contraseña" aria-label="default input example" style="margin-bottom: 20px;">
                <div class="mb-3">
                    <label for="fotos" class="form-label">Foto de Perfil</label>
                    <input type="file" accept="imagen/jpg" name="foto" class="form-control" title="Selecciona una imagen">
                </div>
                <hr>
                <button name="editar" type="submit" class="btn btn-outline-dark" style="width: 250px; height: 50px;margin-bottom: 30px;">Editar</button>
            </form>
        </div>
    </div>
    <footer style="background-color: black; color: white; padding: 20px 0;">
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
                    <a href="https://www.instagram.com/utcoahuila/" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>