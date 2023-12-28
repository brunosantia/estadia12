<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar'])) {
    require_once "../config/conexion.php";

    $accion = $_POST['accion'];
    $id = $_POST['id'];

    if ($accion === 'eliminar_producto') {
        $query = mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
        if ($query) {
            header('Location: productos.php');
        } else {
            // Manejar el error en caso de fallo en la eliminación
        }
    } elseif ($accion === 'eliminar_categoria') {
        // Código para eliminar una categoría
    }
}

?>