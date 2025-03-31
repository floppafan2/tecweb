<?php
    // 1. Inclusión del archivo que contiene la clase Products
    header('Content-Type: application/json; charset=UTF-8');
    error_reporting(0);

    require_once __DIR__.'/../Modelo/Products.php';

    $products = new Products('marketzone'); // Usa tu nombre de BD real

    $producto = file_get_contents('php://input');
    $response = [
        'status' => 'error',
        'message' => 'No se recibieron datos del producto'
    ];

    if(!empty($producto)) {
        $jsonOBJ = json_decode($producto);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            // Verificar si el producto ya existe
            $products->singleByName($jsonOBJ->nombre);
            $existing = json_decode($products->getData(), true);
            
            if(empty($existing) || isset($existing['error'])) {
                // Agregar el producto
                $products->add($jsonOBJ);
                $result = json_decode($products->getData(), true);
                
                if(isset($result['success'])) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Producto agregado correctamente'
                    ];
                } else {
                    $response['message'] = 'Error al agregar el producto: ' . 
                        (isset($result['error']) ? $result['error'] : 'Error desconocido');
                }
            } else {
                $response['message'] = 'Ya existe un producto con ese nombre';
            }
        } else {
            $response['message'] = 'JSON inválido';
        }
    }

    echo json_encode($response);
?>