<?php
session_start();
require_once 'db_conexion.php';

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? null;
    $precio = $_POST['precio'] ?? null;
    $stock = $_POST['stock'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    if ($accion == 'agregar' && $nombre && $precio && $stock && $descripcion) {
        $sql = $cnnPDO->prepare("INSERT INTO productos (nombre, precio, stock, descripcion) 
                                 VALUES (:nombre, :precio, :stock, :descripcion)");
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':precio', $precio);
        $sql->bindParam(':stock', $stock);
        $sql->bindParam(':descripcion', $descripcion);
        $sql->execute();

    } elseif ($accion == 'editar' && $id && $nombre && $precio && $stock && $descripcion) {
        $sql = $cnnPDO->prepare("UPDATE productos 
                                 SET nombre = :nombre, precio = :precio, stock = :stock, descripcion = :descripcion 
                                 WHERE id = :id");
        $sql->bindParam(':nombre', $nombre);
        $sql->bindParam(':precio', $precio);
        $sql->bindParam(':stock', $stock);
        $sql->bindParam(':descripcion', $descripcion);
        $sql->bindParam(':id', $id);
        $sql->execute();

    } elseif ($accion == 'eliminar' && $id) {
        $sql = $cnnPDO->prepare("DELETE FROM productos WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
    }
}

$productos = $cnnPDO->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>
