<?php
session_start();
require_once 'db-conexion.php';

if (isset($_POST['eliminar'])) {
    $id = $_POST['idProd'];

    $query = $cnnPDO->prepare('DELETE FROM productos WHERE idproducto = :id');
    $query->bindParam(':id', $id);

    $query->execute();
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
            <h1 class="nombre text-white">Panel de Control Publicaciones</h1>
            <div class="d-flex gap-5">
                <a href="vista-admin.php">Volver al Inicio</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="Headers my-5 ms-5">
            <h4>Titulo</h4>
            <h4>Imagen</h4>
            <h4>descripcion</h4>
            <h4>Id de producto</h4>
            <h4>Precio</h4>
            <h4>Vendedor</h4>
            <h4>Eliminar</h4>
        </div>
    </div>
    <?php
    $query = $cnnPDO->prepare('SELECT * FROM productos');
    $query->execute();
    echo '<div class="container">';
    echo '<div class="box-container">';
    $contador = 1;
    while ($campo = $query->fetch()) {
        $fotos = unserialize($campo['fotos']);
    ?>

        <div class="box">
            <h5><?php echo $campo["titulo"]; ?></h5>
            <img src='imagenes/<?php echo "$fotos[0]"; ?>' alt="<?php echo $titulo; ?>" class='img-thumbnail' width='200'>
            <p class="description"><?php echo $campo["descripcion"]; ?> </p>
            <p><?php echo $campo["idproducto"]; ?></p>
            <P><?php echo $campo["precio"]; ?></P>
            <p><?php echo $campo["vendedor"]; ?></p>
            <form method="post">
                <input type="hidden" name="idProd" value="<?php echo $campo["idproducto"]; ?>">
                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar Publicacion</button>
            </form>
        </div>
    <?php
        $contador = $contador + 1;
    }
    ?>
    <style>
        .container .box-container {
            display: grid;
            grid-template-rows: repeat(auto-fit, minmax(270px, 1fr));
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
    <br><br><br>
</body>

</html>