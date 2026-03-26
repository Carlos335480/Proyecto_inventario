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

    <div class="container mt-5">
        <div class="row gap-4 animar-fade-up">
            <div class="col-md-4">
                <div class="shadow p-4 d-flex flex-column gap-4 caja-sesion w-100 m-0 text-center">
                    <div class="d-flex flex-column align-items-center gap-2">
                        <img src='imagenes/<?php echo unserialize($campo['foto']); ?>' alt="Foto de perfil" class="rounded-circle border border-info border-3" style="width: 150px; height: 150px; object-fit: cover; margin-top: 1rem;">
                        <p class="display-6 mt-3 text-info"><?php echo $_SESSION['nombre']; ?></p>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="text-secondary">Correo Electrónico</h5>
                        <p style="font-size: 17px;"><?php echo $_SESSION['correo']; ?></p>
                    </div>
                    <div class="text-start ms-3">
                        <h5 class="text-secondary">ID de Usuario</h5>
                        <p style="font-size: 17px;"><?php echo $_SESSION['idUsuario']; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <form method="post" enctype="multipart/form-data" class="shadow p-5 caja-sesion w-100 m-0">
                    <p class="display-6 text-info">Edita tu perfil</p>
                    <p class="text-secondary">Modifica solo lo que desees cambiar</p>
                    <hr class="border-secondary">
                    <input name="nombre" class="form-control mb-3" type="text" placeholder="Nuevo Nombre">
                    <input name="correo" class="form-control mb-3" type="email" placeholder="Nuevo Correo">
                    <input name="password" class="form-control mb-3" type="password" placeholder="Nueva Contraseña">
                    <div class="mb-4">
                        <label for="fotos" class="form-label text-light">Foto de Perfil</label>
                        <input type="file" accept="image/*" name="foto" class="form-control">
                    </div>
                    <hr class="border-secondary mb-4">
                    <button name="editar" type="submit" class="btn btn-outline-info w-100 fs-5">Guardar Cambios</button>
                </form>
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