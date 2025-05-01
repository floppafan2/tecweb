<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    use Slim\Psr7\Response as SlimResponse;
    
    require_once __DIR__ . '/../vendor/autoload.php';

    use myapi\Create\Create;
    use myapi\Read\Read;
    use myapi\Delete\Delete;
    use myapi\Update\Update;

    $app = AppFactory::create();

    $app->setBasepath("/tecweb/ejercicios/e04/product_app/backend");

    $app->get('/products/{id:[0-9]+}', function (Request $request, Response $response, $args) {
        $read = new Read('marketzone');
        $read->single($args['id']);
        $data = $read->getData();
        $response->getBody()->write($data ?: '{}');
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/products', function ($request, $response, $args) {
        $read = new Read('marketzone'); // Usa tu nombre real de BD
        $read->list();
    
        $response->getBody()->write($read->getData());
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->get('/products/{search}', function (Request $request, Response $response, $args) {
        $read = new Read('marketzone');
        $read->search($args['search']);
    
        $response->getBody()->write($read->getData());
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/products', function (Request $request, Response $response) {
        $body = json_decode($request->getBody());
    
        if (!$body) {
            $response->getBody()->write(json_encode(['error' => 'JSON inválido']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    
        $create = new Create('marketzone');
        $create->add($body);
    
        $response->getBody()->write(json_encode($create->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    $app->put('/products', function (Request $request, Response $response) {
        // Obtener el cuerpo como JSON
        $json = $request->getBody()->getContents();
        
        // Verificar que sea JSON válido
        $data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response->getBody()->write(json_encode([
                'status' => 'error',
                'message' => 'JSON inválido'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    
        // Verificar ID
        if (!isset($data['id'])) {
            return $response->withJson([
                'status' => 'error',
                'message' => 'Se requiere el ID del producto'
            ], 400);
        }
    
        // Separar ID y los demás datos
        $id = $data['id'];
        unset($data['id']); // Eliminar ID del array de datos
    
        // Procesar actualización
        $update = new Update('marketzone');
        $update->edit($id, $data); // Pasa ID y datos por separado
    
        $response->getBody()->write(json_encode($update->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->delete('/products', function (Request $request, Response $response) {
        $body = $request->getBody()->getContents();
        $data = json_decode($body, true);
        $id = $data['id'] ?? null;
    
        $prod = new Delete('marketzone');
        $prod->delete($id);
    
        $response->getBody()->write(json_encode($prod->getData()));
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->run();
?>