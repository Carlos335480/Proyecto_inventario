<?php
session_start();
require_once 'C:\xampp\htdocs\codigosphp\codigosphp\crud\db_conexion.php';

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = $_POST['id'] ?? null;
    $marca = $_POST['marca'] ?? null;
    $modelo = $_POST['modelo'] ?? null;
    $anio = $_POST['anio'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $imagen = $_POST['imagen'] ?? null;

    if ($accion == 'agregar' && $id && $marca && $modelo && $anio && $precio) {
        $sql = $cnnPDO->prepare("INSERT INTO autos (id, marca, modelo, anio, precio, descripcion, imagen) VALUES (:id, :marca, :modelo, :anio, :precio, :descripcion, :imagen)");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':marca', $marca);
        $sql->bindParam(':modelo', $modelo);
        $sql->bindParam(':anio', $anio);
        $sql->bindParam(':precio', $precio);
        $sql->bindParam(':descripcion', $descripcion);
        $sql->bindParam(':imagen', $imagen);
        $sql->execute();
    } elseif ($accion == 'editar' && $id && $marca && $modelo && $anio && $precio) {
        $sql = $cnnPDO->prepare("UPDATE autos SET marca = :marca, modelo = :modelo, anio = :anio, precio = :precio, descripcion = :descripcion, imagen = :imagen WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':marca', $marca);
        $sql->bindParam(':modelo', $modelo);
        $sql->bindParam(':anio', $anio);
        $sql->bindParam(':precio', $precio);
        $sql->bindParam(':descripcion', $descripcion);
        $sql->bindParam(':imagen', $imagen);
        $sql->execute();
    } elseif ($accion == 'eliminar' && $id) {
        $sql = $cnnPDO->prepare("DELETE FROM autos WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
    }
}

$autos = $cnnPDO->query("SELECT * FROM autos")->fetchAll(PDO::FETCH_ASSOC);
?>