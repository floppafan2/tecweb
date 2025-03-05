<?php
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');
if(!empty($producto)) {
    // SE TRANSFORMA EL STRING DEL JSON A OBJETO
    $jsonOBJ = json_decode($producto);

    // VALIDACIÓN DE PRODUCTOS DUPLICADOS
    $nombre = $jsonOBJ->nombre;
    $marca = $jsonOBJ->marca;
    $modelo = $jsonOBJ->modelo;

    $sqlCheck = "SELECT COUNT(*) FROM productos WHERE (nombre = '$nombre' AND marca = '$marca') OR (marca = '$marca' AND modelo = '$modelo') AND eliminado = 0";
    $resultCheck = $conexion->query($sqlCheck);

    if ($resultCheck->fetch_assoc()['COUNT(*)'] > 0) {
        echo json_encode(array('status' => 'error', 'message' => 'El producto ya existe.'));
    } else {
        // INSERCIÓN DEL PRODUCTO
        $precio = $jsonOBJ->precio;
        $unidades = $jsonOBJ->unidades;
        $detalles = $jsonOBJ->detalles;
        $imagen = $jsonOBJ->imagen;

        $sqlInsert = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen) VALUES ('$nombre', $precio, $unidades, '$modelo', '$marca', '$detalles', '$imagen')";

        if ($conexion->query($sqlInsert) === TRUE) {
            echo json_encode(array('status' => 'success', 'message' => 'Producto agregado correctamente.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo agregar el producto: ' . $conexion->error));
        }
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'No se recibieron datos del producto.'));
}

$conexion->close();
?>