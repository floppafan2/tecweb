<?php
include_once __DIR__ . '/database.php';

header('Content-Type: application/json; charset=UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el ID desde la URL
$id = $_GET['id'];

// Obtener el cuerpo de la solicitud POST (JSON)
$producto = file_get_contents('php://input');
$data_mesage = array(
    'status' => 'error',
    'message' => 'Hubo un fallo en la modificación' //Mensaje de error predeterminado.
);

if (!empty($producto)) {
    // Decodificar el JSON como un array asociativo
    $data = json_decode($producto, true);
    if (json_last_error() === JSON_ERROR_NONE) { // Verifica que el JSON sea válido
        $nombre = $data['nombre'];
        $sql = "SELECT * FROM productos WHERE id = '$id';";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $conexion->set_charset("utf8");
            $sql = "UPDATE productos SET nombre='$nombre', marca='{$data['marca']}', modelo='{$data['modelo']}', precio={$data['precio']}, detalles='{$data['detalles']}', unidades={$data['unidades']}, imagen='{$data['imagen']}' WHERE id='$id';";
            if ($conexion->query($sql)) {
                echo json_encode(["status" => "success", "message" => "Producto actualizado correctamente"]);
                exit;
            } else {
                $data_mesage['message'] = "ERROR: No se ejecutó el comando. " . $conexion->error; // Añadido el error de la conexion.
            }
        } else {
            $data_mesage['message'] = "No se encontró el producto";
        }
        $result->free();
    } else {
        $data_mesage['message'] = "Error: JSON inválido recibido.";
    }
} else {
    $data_mesage['message'] = "No se recibieron datos.";
}

// Cierra la conexión
$conexion->close();

// Devuelve la respuesta en formato JSON
echo json_encode($data_mesage, JSON_PRETTY_PRINT);
?>
