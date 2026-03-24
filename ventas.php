if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = $_POST['id'] ?? null;
    $fecha = $_POST['fecha'] ?? date('Y-m-d H:i:s'); 
    $total = $_POST['total'] ?? null;

    if ($accion == 'agregar' && $total) {
        $sql = $cnnPDO->prepare("INSERT INTO ventas (fecha, total) VALUES (:fecha, :total)");
        $sql->bindParam(':fecha', $fecha);
        $sql->bindParam(':total', $total);
        $sql->execute();

    } elseif ($accion == 'editar' && $id && $fecha && $total) {
        $sql = $cnnPDO->prepare("UPDATE ventas SET fecha = :fecha, total = :total WHERE id = :id");
        $sql->bindParam(':fecha', $fecha);
        $sql->bindParam(':total', $total);
        $sql->bindParam(':id', $id);
        $sql->execute();

    } elseif ($accion == 'eliminar' && $id) {
        $sql = $cnnPDO->prepare("DELETE FROM ventas WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->execute();
    }
}

$ventas = $cnnPDO->query("SELECT * FROM ventas")->fetchAll(PDO::FETCH_ASSOC);
