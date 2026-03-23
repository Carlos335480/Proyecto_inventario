<?php

require_once 'db_conexion.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $sql = "INSERT INTO usuarios (id, nombre, email, password, rol) VALUES (?, ?, ?, ?)";

    
    $stmt = $cnnPDO->prepare($sql);
    
    
    if ($stmt->execute([$id, $nombre, $email, $password])) {
        echo "Registro exitoso";
        
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    
    $stmt = null;
}


$cnnPDO = null;
?>