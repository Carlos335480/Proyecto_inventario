<?php
    session_start();
    require_once 'db-conexion.php';

    $sql = $cnnPDO -> prepare('SELECT * FROM productos WHERE idproducto = :id');
    $sql -> bindParam(':id', $_GET['id']);
    $sql -> execute();

    $campos = $sql -> fetch();
    unset($sql);

    $fotos_serializadas = $campos["fotos"];
    $fotos = unserialize($fotos_serializadas);

    if (isset($_POST['comprar'])) {
        if (empty($_SESSION['nombre'])) {
            header('location: registro-inicio.php?sesion=no');
        } else {
            header('location: pantalla_de_pago.php?id=' . $campos['idproducto']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $campos['titulo']; ?></title>
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

    <div class="d-flex pt-5 justify-content-evenly">

        <div class="ms-5" style="width: 45%; height: 80vh;">
            <div style="width: 100%; height: 100%;">
                <img src="imagenes/<?php echo $fotos[0]; ?>" class="d-block w-100 h-100" style="object-fit: cover;">
            </div>
        </div>

        <div class="info-juego d-flex flex-column justify-content-between">
            <div>
                <h1 class="text-center display-1 mb-5 animate__animated animate__bounceInDown"><?php echo $campos['titulo']; ?></h1>
                <p><?php echo $campos['descripcion']; ?></p>
                <h3 class="animate__animated animate__backInDown precio text-center display-4">$<?php echo $campos['precio']; ?></h3>
                <div class="d-flex justify-content-between">
                    <p>Vendedor: <?php echo $campos['vendedor']; ?></p>
                </div>
            </div>
            <form method="post" class="text-center p-5">
                <button class="btn btn-outline-danger p-3" type="submit" name="comprar">Comprar</button>
            </form>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
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