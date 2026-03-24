<?php
session_start();
require_once 'db-conexion.php';

if (empty($_SESSION['nombre'])) {
    header('location: index.php');
}

if (isset($_POST['publicar'])) {
    $id = uniqid();
    $titulo = $_POST["titulo"];
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];


    $fotos = $_FILES["fotos"];
    $foto_nombres = array();
    foreach ($fotos["tmp_name"] as $key => $tmp_name) {
        $foto_nombre = $fotos["name"][$key];
        $foto_nombres[] = $foto_nombre;
        move_uploaded_file($tmp_name, "imagenes/" . $foto_nombre);
    }

    // Preparar y ejecutar la consulta para insertar los datos en la tabla 'productos'
    $sql = $cnnPDO->prepare("INSERT INTO productos (idproducto, idvendedor, vendedor, titulo, precio, descripcion, fotos) VALUES (:id, :idvendedor, :vendedor, :titulo, :precio, :descripcion, :fotos)");
    $fotos_serializadas = serialize($foto_nombres);

    $sql->bindParam(':id', $id);
    $sql->bindParam(':idvendedor', $_SESSION['idUsuario']);
    $sql->bindParam(':vendedor', $_SESSION['nombre']);
    $sql->bindParam(':titulo', $titulo);
    $sql->bindParam(':precio', $precio);
    $sql->bindParam(':descripcion', $descripcion);
    $sql->bindParam(':fotos', $fotos_serializadas);

    if ($sql->execute()) {
        header('location: index.php');
    } else {
        header('location: vender.php');
        echo "Error al agregar el producto.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vender Mercado UTC</title>
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
    <div class="ms-5" style="text-align: center;">
        <h1 class="display-4">Publica un articulo para vender</h1>
        <p>Completa la siguiente informacion</p>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div id="miCarrusel" class="carousel carousel-producto slide mx-auto mt-5">
            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <div class="paso-publicar ">
                        <h4 class="display-5 titulos mt-5"> - Titulo de la publicacion - </h4>
                        <input type="text" name="titulo" class="form-control mx-auto" required>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="paso-publicar">
                        <h4 class="display-5 titulos mt-5">Precio del producto</h4>
                        <input type="number" name="precio" class="form-control mx-auto" required>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="paso-publicar">
                        <h4 class="display-5 titulos mt-5">Agrega una descripcion</h4>
                        <textarea name="descripcion" class="form-control" cols="30" rows="10" required></textarea>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="paso-publicar">
                        <h4 class="display-5 titulos mt-5">Imagen del producto</h4>
                        <input type="file" class="form-control" name="fotos[]" multiple required>
                        <button class="btn btn-outline-dark mt-2" name="publicar">Publicar</button>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#miCarrusel" data-bs-slide="prev">
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#miCarrusel" data-bs-slide="next">
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </form>
    <br>
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
                    <!-- Ícono de Instagram -->
                    <a href="https://www.instagram.com/utcoahuila/" target="_blank" style="color: white; text-decoration: none; margin-right: 10px;">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Detener el avance automático del carrusel
        var miCarrusel = new bootstrap.Carousel(document.getElementById('miCarrusel'), {
            interval: false // Puedes cambiar false por un número de milisegundos para ajustar la velocidad
        });
    </script>
</body>

</html>