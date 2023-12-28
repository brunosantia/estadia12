<?php
require_once "config/conexion.php";

if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $productos_en_carrito = array(); // Para llevar un registro de los productos y sus cantidades
        $total = 0;
        
        // Filtrar los datos del POST
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Validar y recorrer los datos del POST
        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $producto) {
                $id = filter_var($producto['id'], FILTER_VALIDATE_INT);
                
                if ($id !== false) {
                    $query = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
                    $result = mysqli_fetch_assoc($query);
                    
                    // Crear una clave única para cada producto (puede ser el ID)
                    $clave_producto = $result['id'];
                    
                    // Verificar si el producto ya existe en el carrito
                    if (array_key_exists($clave_producto, $productos_en_carrito)) {
                        // Si existe, incrementar la cantidad
                        $productos_en_carrito[$clave_producto]['cantidad']++;
                    } else {
                        // Si es la primera vez que se agrega, crear un nuevo registro en el carrito
                        $productos_en_carrito[$clave_producto] = array(
                            'id' => $result['id'],
                            'id_categoria' => $result['id_categoria'],
                            'precio_normal' => $result['precio_normal'],
                            'nombre' => $result['nombre'],
                            'cantidad' => 1 // Inicializar la cantidad en 1
                        );
                    }
                    
                    // Sumar al total (precio del producto por su cantidad)
                    $total += $result['precio_normal'];
                }
            }
        }
        
        // Agregar los productos del carrito al array final
        $array['datos'] = array_values($productos_en_carrito); // Reindexar el array
        
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}
?>
