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

    <div class="container pt-5 pb-5">
        <div class="row align-items-center justify-content-evenly animar-fade-up">
            <div class="col-md-5">
                <div class="shadow rounded overflow-hidden" style="height: 60vh;">
                    <img src="imagenes/<?php echo $fotos[0]; ?>" class="w-100 h-100" style="object-fit: cover;">
                </div>
            </div>

            <div class="col-md-5 info-juego p-5 d-flex flex-column justify-content-between" style="height: auto;">
                <div>
                    <h1 class="text-center display-4 mb-4 text-info border-bottom border-secondary pb-3"><?php echo $campos['titulo']; ?></h1>
                    <p class="fs-5 text-light"><?php echo $campos['descripcion']; ?></p>
                    <h3 class="precio text-center display-4 text-success my-4">$<?php echo $campos['precio']; ?></h3>
                    <p class="fs-5 text-secondary">Vendedor: <span class="text-light"><?php echo $campos['vendedor']; ?></span></p>
                </div>
                <form method="post" class="text-center mt-4">
                    <button class="btn btn-outline-success p-3 w-100 fs-4" type="submit" name="comprar">Comprar Ahora</button>
                </form>
            </div>
        </div>
    </div>
    
    <footer style="padding: 20px 0; margin-top: 5rem;">
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