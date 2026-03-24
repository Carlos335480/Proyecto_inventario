<?php
session_start();
include_once 'db-conexion.php';

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: index.php');
}

if (empty($_SESSION['nombre'])) {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracion UTC Market</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
</head>
<body>
    <nav class="shadow p-5 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <div class="d-flex gap-5">
                <form method="post">
                    <button class="btn btn-danger" name="logout">Cerrar Sesion</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container text-center">
        <h1 class="display-1">Bienvenida Administradora</h1>
        <p style="font-size: 25px;">¿Qué desea hacer hoy?</p>

        <div class="mt-4 d-flex gap-5 cards justify-content-center">
            <a class="shadow d-flex flex-column p-5 gap-5 card-admin align-items-center" href="panel-publicaciones.php">
                <img src="imagenes/publicaciones.png" alt="publicaciones">
                <h3>Administrar Publicaciones</h3>
            </a>
            <a class="shadow d-flex flex-column p-5 gap-5 card-admin align-items-center" href="panel-ventas.php">
                <img src="imagenes/ventas.png" alt="publicaciones">
                <h3>observar Ventas</h3>
            </a>
        </div>
    </div>
    <br><br><br>

</html>