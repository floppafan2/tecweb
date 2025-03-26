<?php
    /*include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
        'status'  => 'error',
        'message' => 'Ya existe un producto con ese nombre'
    );
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
        $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
	    $result = $conexion->query($sql);
        
        if ($result->num_rows == 0) {
            $conexion->set_charset("utf8");
            $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
            if($conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
            }
        }

        $result->free();
        // Cierra la conexion
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/
    // 1. Inclusión del archivo que contiene la clase Products
    require_once __DIR__.'/myapi/Products.php';

    // 2. Creación del objeto de la clase principal
    $products = new Products('marketzone'); // Reemplaza con el nombre real de tu BD

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');

    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        // 3. Invocación al método de la operación correspondiente
        // Primero verificamos si el producto existe
        $products->singleByName($jsonOBJ->nombre);
        $existingProduct = json_decode($products->getData(), true);
        
        if(empty($existingProduct) || isset($existingProduct['error'])) {
            // Si no existe, lo añadimos
            $products->add($jsonOBJ);
            
            // Actualizamos el mensaje de éxito
            $products->data = [
                'status' => 'success',
                'message' => 'Producto agregado'
            ];
        } else {
            // Si existe, preparamos mensaje de error
            $products->data = [
                'status' => 'error',
                'message' => 'Ya existe un producto con ese nombre'
            ];
        }
    } else {
        $products->data = [
            'status' => 'error',
            'message' => 'No se recibieron datos del producto'
        ];
    }

    // 4. Devolver la información solicitada en formato JSON
    header('Content-Type: application/json');
    echo $products->getData();
?>