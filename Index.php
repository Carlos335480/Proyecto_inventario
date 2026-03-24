<?php
session_start();
require_once 'db-conexion.php';

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado UTC</title>
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-aw esome/5.15.1/css/all.min.css">
</head>
</head>

<body>
    <nav class="shadow p-5">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <div class="d-flex gap-5 align-items-center">
                <?php if (empty($_SESSION['nombre'])) { ?>
                    <a href="registro-inicio.php" class="btn btn-primary">Inicia Sesion / Registrate</a>
                <?php } else { ?>
                    <a href="#"><?php echo 'usuario: ' . $_SESSION['nombre']; ?></a>
                    <a href="agregar-producto.php">Vende Tu Producto</a>
                    <a href="perfil.php">Tu Perfil</a>
                    <form method="post">
                        <button class="btn btn-danger" name="logout">Cerrar Sesion</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="seccion-juegos">
        <h2 class="display-3 ms-5 mt-4 mb-5" style="font-family: 'Kalam', cursive; text-decoration: underline;">Los Mejores Productos</h2>
        <?php
        // Mostrar los juegos y sus fotos
        $sql = "SELECT idproducto, titulo, precio, fotos FROM productos";
        $result = $cnnPDO ->query($sql);
        $result->execute();

        $count = $result->rowCount();

        if ($count) {

            echo "<div class='container d-flex flex-wrap gap-3' style='padding-bottom: 10rem;'>";
            while ($row = $result->fetch()) {
                $id = $row['idproducto'];
                $titulo = $row["titulo"];
                $precio = $row["precio"];
                $fotos_serializadas = $row["fotos"];
                $fotos = unserialize($fotos_serializadas);
        ?>
                <a class="producto ms-1 me-5 mt-2" href="ver-producto.php?id=<?php echo $id ?>">
                    <div class="" style="background: url(imagenes/<?php echo $fotos[0]; ?>); background-size: cover; background-position: center; background-repeat: no-repeat; width: 16rem; height: 20rem;">

                    </div>
                    <div class="d-flex" style="width: 16rem;">
                        <div class="d-flex flex-column gap-2 mt-2">
                            <h3><?php echo $titulo; ?></h3>
                            <p>$<?php echo $precio; ?></p>
                        </div>
                    </div>
                </a>
        <?php
            }
            echo "</div>";
        }
        ?>
    </div>
    <footer style="background-color: black; color: white; padding: 40px 35px;">
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
</html>