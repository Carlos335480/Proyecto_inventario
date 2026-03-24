<?php
session_start();
require_once 'db-conexion.php';

if (empty($_SESSION['nombre'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Publicaciones</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
</head>

<body>
    <nav class="shadow p-5 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <h1 class="nombre text-white">Panel de Control Ventas</h1>
            <div class="d-flex gap-5">
                <a href="vista-admin.php">Volver al Inicio</a>
            </div>
        </div>
    </nav>
    <div class="container">

        <div class="Headers ms-5">

            <h4>ID</h4>
            <h4>ID Comprador</h4>
            <h4>Vendedor</h4>
            <h4>Fecha De Compra</h4>
            <h4>entrega</h4>
        </div>

    </div>

    <?php
    $query = $cnnPDO->prepare('SELECT * FROM compras');
    $query->execute();
    echo '<div class="container">';
    echo '<div class="box-container">';
    while ($campo = $query->fetch()) {
    ?>

        <div class="box">
            <p> <?php echo $campo["idcompra"]; ?> </p>
            <p>|</p>
            <p> <?php echo $campo["idcomprador"]; ?> </p>
            <p>|</p>
            <p> <?php echo $campo["vendedor"]; ?> </p>
            <p>|</p>
            <p> <?php echo $campo["fecha"]; ?> </p>
            <p>|</p>
            <p> <?php echo $campo["domicilio"]; ?> </p>

        </div>
    <?php
    }
    ?>
    </div>
    <style>
        .container .box-container {
            display: grid;
            gap: 15px;
        }

        .Headers {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
        }

        .container .box-container .box {
            box-shadow: 0 5px 10px rgba(0, 0, 0, .2);
            border-radius: 5px;
            background: #fff;
            text-align: center;
            padding: 30px 20px;
            transition: 0.5s;
        }

        .container .box-container .box img {
            height: 80px;
        }

        .container .box-container .box h3 {
            color: #444;
            font-size: 22px;
            padding: 10px 0;
        }

        .container .box-container .box p {
            color: #777;
            font-size: 15px;
            line-height: 1.8;
        }

        .container .box-container .box .btn:hover {
            letter-spacing: 1px;
        }

        .container .box-container .box:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, .3);
            transform: scale(1.05);
        }

        .box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 5px;
            align-items: space-evenly;
        }

        h1 {
            text-align: center;
        }

        .description {
            text-align: justify;
        }
    </style>

</body>

</html>