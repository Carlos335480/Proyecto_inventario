<?php
session_start();
require_once 'db_conexion.php';

if (isset($_POST['iniciar_sesion'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Correo y contraseña son requeridos.";
    } else {
        $select = $cnnPDO->prepare('SELECT * FROM usuarios WHERE email = ? AND password = ?');
        $select->execute([$email, $password]);
        $count = $select->rowCount();
        $campo = $select->fetch();

        if ($count > 0) {
            $_SESSION['nombre'] = $campo['nombre'];
            $_SESSION['email'] = $campo['email'];

            if (strpos($campo['email'], 'admin_') === 0) {
                header('Location: inicio_admin.php');
            } else {
                header('Location: ventas.php');
            }
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    }
}
?>