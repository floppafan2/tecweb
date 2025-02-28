<?php
// Conectar a la base de datos
@$link = new mysqli('localhost', 'root', '7*Vl*zwyPeGlNLTm', 'marketzone');
// Verificar conexión
if ($link->connect_errno) {
    die('<p class="alert alert-danger">Falló la conexión: ' . $link->connect_error . '</p>');
}
// Obtener el ID del producto desde la URL
$productoID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto = null;

if ($productoID > 0) {
    // Consultar los datos del producto
    $stmt = $link->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $productoID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    }
    $stmt->close();
}
$link->close();
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" >
    <title>Formulario de Productos</title>
    <style type="text/css">
      ol, ul { 
      list-style-type: none;
      }
    </style>
  </head>
  <body>
    <h1>Formulario de productos</h1>
      <form id="formularioProductos" action="http://localhost/tecweb/practicas/p09/update_producto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($producto['id'] ?? '') ?>">

        <fieldset>
          <legend>Información del Producto</legend>
              <li><label for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre'] ?? '') ?>" required></li>

              <li><label for="marca">Marca:</label>
              <input type="text" id="marca" name="marca" class="form-control" value="<?= htmlspecialchars($producto['marca'] ?? '') ?>" required></li>

              <li><label for="modelo">Modelo:</label>
              <input type="text" id="modelo" name="modelo" class="form-control" value="<?= htmlspecialchars($producto['modelo'] ?? '') ?>" required></li>

              <li><label for="precio">Precio:</label>
              <input type="number" id="precio" name="precio" class="form-control" value="<?= htmlspecialchars($producto['precio'] ?? '') ?>" step="0.01" required></li>

              <li><label for="unidades">Unidades:</label>
              <input type="number" id="unidades" name="unidades" class="form-control" value="<?= htmlspecialchars($producto['unidades'] ?? '') ?>" required></li>

              <li><label for="detalles">Detalles:</label>
              <textarea id="detalles" name="detalles" class="form-control"><?= htmlspecialchars($producto['detalles'] ?? '') ?></textarea></li>

              <li><label for="form-image">Imagen del producto:</label> <input type="file" name="image" id="imagen" accept="image/png"></li>
        </fieldset>

        <input type="submit" value="Subir producto">
        </script>
      </form>
      <button onclick="window.history.back();">Regresar</button>
  </body>
</html>
