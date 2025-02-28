<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
    if(isset($_GET['tope']))
    {
        $tope = $_GET['tope'];
        // Validar que 'tope' sea un número entero positivo
        if (!ctype_digit($tope)) {
            die('Error: El parámetro "tope" debe ser un número entero positivo.');
        }
        $tope = (int) $tope; // Convertimos a entero seguro
    }
    else
    {
        die('Parámetro "tope" no detectado...');
    }
    if (!empty($tope))
    {
        /** SE CREA EL OBJETO DE CONEXION */
        @$link = new mysqli('localhost', 'root', '7*Vl*zwyPeGlNLTm', 'marketzone');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */

        /** comprobar la conexión */
        if ($link->connect_errno) 
        {
            die('Falló la conexión: '.$link->connect_error.'<br/>');
        }
        /** Obtener los productos con unidades menores o iguales al tope */
        $productos = [];
        if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= $tope") )
        {
            $productos = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
        }
        $link->close();
    }
    ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Productos xhtml</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <script>
            function redirigir(idProducto) {
                localStorage.setItem("productoID", idProducto); // Guarda la ID en localStorage
                window.location.href = "http://localhost/tecweb/practicas/p09/formulario_productos_v2.php?id=" + idProducto;
            }
        </script>
        <h3 class="mt-4">PRODUCTOS</h3>
        <br/>
        <?php if( !empty($productos) ) : ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Unidades</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                    <tr>
                        <th scope="row"><?= htmlspecialchars($producto['id']) ?></th>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['marca']) ?></td>
                        <td><?= htmlspecialchars($producto['modelo']) ?></td>
                        <td><?= htmlspecialchars($producto['precio']) ?></td>
                        <td><?= htmlspecialchars($producto['unidades']) ?></td>
                        <td><?= htmlspecialchars($producto['detalles']) ?></td>
                        <td><img src="<?= htmlspecialchars($producto['imagen']) ?>" width="100"></td>
                        <td><button onclick="redirigir(<?= htmlspecialchars($producto['id']) ?>)">Modificar</button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">No hay productos con unidades menores o iguales a <?= htmlspecialchars($tope) ?>.</p>
        <?php endif; ?>
    </body>
</html>
