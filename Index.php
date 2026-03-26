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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="imagenes/logo2.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
    <nav class="shadow p-5 animar-fade-in visible">
        <div class="d-flex justify-content-between align-items-center">
            <img src="imagenes/logo3.png" alt="Mercado UTC">
            <div class="d-flex gap-5 align-items-center">
                <?php if (empty($_SESSION['nombre'])) { ?>
                    <a href="registro-inicio.php" class="btn btn-outline-light text-white">Inicia Sesion / Registrate</a>
                <?php } else { ?>
                    <a href="#" class="text-info"><?php echo 'Usuario: ' . $_SESSION['nombre']; ?></a>
                    <a href="agregar-producto.php">Vende Tu Producto</a>
                    <a href="perfil.php">Tu Perfil</a>
                    <form method="post" class="m-0">
                        <button class="btn btn-danger" name="logout">Cerrar Sesion</button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </nav>

    <div class="seccion-juegos">
        <h2 class="display-4 ms-5 mt-4 mb-5 animar-fade-up" style="font-family: 'Kalam', cursive; border-bottom: 2px solid #333; display: inline-block;">Los Mejores Productos</h2>
        <?php
        $sql = "SELECT idproducto, titulo, precio, fotos FROM productos";
        $result = $cnnPDO->query($sql);
        $result->execute();

        $count = $result->rowCount();

        if ($count) {
            echo "<div class='container d-flex flex-wrap gap-4 justify-content-center' style='padding-bottom: 10rem;'>";
            while ($row = $result->fetch()) {
                $id = $row['idproducto'];
                $titulo = $row["titulo"];
                $precio = $row["precio"];
                $fotos_serializadas = $row["fotos"];
                $fotos = unserialize($fotos_serializadas);
        ?>
                <a class="producto animar-fade-up" href="ver-producto.php?id=<?php echo $id ?>" style="width: 16rem;">
                    <div style="background: url(imagenes/<?php echo $fotos[0]; ?>); background-size: cover; background-position: center; background-repeat: no-repeat; height: 18rem;">
                    </div>
                    <div class="p-3">
                        <h4 class="text-light"><?php echo $titulo; ?></h4>
                        <p class="text-success fs-5 fw-bold">$<?php echo $precio; ?></p>
                    </div>
                </a>
        <?php
            }
            echo "</div>";
        }
        ?>
    </div>
    <footer style="padding: 40px 35px;">
        <div class="container animar-fade-up">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-info">Contactanos</h4>
                    <p>Dirección: Av. Industria Metalúrgica No. 2001, Ramos Arizpe, Mexico</p>
                    <p>Teléfono: +1 844-288-3800</p>
                </div>
                <div class="col-md-6">
                    <h4 class="text-info">Síguenos</h4>
                    <a href="https://www.facebook.com/UniversidadTecnologicadeCoahuila/?locale=es_LA" target="_blank" class="text-light fs-4 me-3">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/utcoahuila/" target="_blank" class="text-light fs-4">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="animaciones.js"></script>
</body>
</html>