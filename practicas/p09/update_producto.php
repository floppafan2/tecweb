<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Modificación de Producto</title>
    <style type="text/css">
        body {
            margin: 20px;
            background-color: #C4DF9B;
            font-family: Verdana, Helvetica, sans-serif;
            font-size: 90%;
        }
        h1 {
            color: #005825;
            border-bottom: 1px solid #005825;
        }
        h2 {
            font-size: 1.2em;
            color: #4A0048;
        }
    </style>
    </head>
    <body>
        <script>
            function mandarTope(idProducto) {
                window.location.href = "http://localhost/tecweb/practicas/p09/get_productos_xhtml_v2.php";
            }
            function mandarVigencia(idProducto) {
                window.location.href = "http://localhost/tecweb/practicas/p09/get_productos_vigentes_v2.php";
            }
        </script>
    <?php
// Conectar a la base de datos
@$link = new mysqli('localhost', 'root', '7*Vl*zwyPeGlNLTm', 'marketzone');

// Verificar conexión
if ($link->connect_errno) {
    die('<p class="alert alert-danger">Falló la conexión: ' . $link->connect_error . '</p>');
}

// Verificar si se enviaron datos desde el formulario
if (!empty($_POST['id']) && isset($_POST['nombre'], $_POST['marca'], $_POST['modelo'], $_POST['precio'], $_POST['unidades'], $_POST['detalles'])) {
    $id = intval($_POST['id']); // Obtener ID desde el formulario
    $nombre = trim($_POST['nombre']);
    $marca  = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $precio = floatval($_POST['precio']);
    $unidades = intval($_POST['unidades']);
    $detalles = trim($_POST['detalles']);

    // Obtener la imagen actual para no perderla si no se sube una nueva
    $stmt_check = $link->prepare("SELECT imagen FROM productos WHERE id = ?");
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$stmt_check->bind_result($imagen_actual);
$stmt_check->fetch();
$stmt_check->close();

// Verificar si se ha subido una nueva imagen
if (!empty($_FILES['imagen']['name'])) {
    $fileTmpPath = $_FILES["imagen"]["tmp_name"];
    $fileName = basename($_FILES["imagen"]["name"]);
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ["png", "jpg", "jpeg"];
    
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadDir = "img/"; // Directorio donde se guardará la imagen
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generar un nombre único para la nueva imagen
        $nueva_imagen = $uploadDir . uniqid() . "." . $fileExtension;

        if (move_uploaded_file($fileTmpPath, $nueva_imagen)) {
            $imagen = $nueva_imagen; // Se asigna la nueva imagen
        } else {
            echo "<p class='alert alert-danger'>❌ Error al mover la nueva imagen.</p>";
            $imagen = $imagen_actual; // Mantiene la imagen anterior en caso de error
        }
    } else {
        echo "<p class='alert alert-warning'>⚠ Formato de imagen no permitido. Solo PNG, JPG, JPEG.</p>";
        $imagen = $imagen_actual;
    }
} else {
    $imagen = $imagen_actual; // Si no se sube nueva imagen, conservar la anterior
}

// Actualizar los datos del producto en la base de datos
$sql_update = "UPDATE productos 
               SET nombre = ?, marca = ?, modelo = ?, precio = ?, unidades = ?, detalles = ?, imagen = ?
               WHERE id = ?";
    
$stmt_update = $link->prepare($sql_update);
if ($stmt_update) {
    $stmt_update->bind_param("sssdisii", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen, $id);
    
    if ($stmt_update->execute()) {
        echo "<p class='alert alert-success'>✅ Producto actualizado con éxito.</p>";
    } else {
        echo "<p class='alert alert-danger'>❌ Error al actualizar el producto: " . $stmt_update->error . "</p>";
    }

    $stmt_update->close();
} else {
    echo "<p class='alert alert-danger'>❌ Error en la consulta de actualización.</p>";
}

$link->close();
} else {
    echo "<p class='alert alert-warning'>⚠ Error: Datos incompletos en el formulario.</p>";
}
?>

    <h1>Producto Modificado</h1>

    <h2>Detalles del producto actualizado:</h2>
    <ul>
        <li><strong>ID:</strong> <em><?php echo htmlspecialchars($_POST['id'] ?? 'No disponible'); ?></em></li>
        <li><strong>Nombre:</strong> <em><?php echo htmlspecialchars($_POST['name'] ?? 'No disponible'); ?></em></li>
        <li><strong>Marca:</strong> <em><?php echo htmlspecialchars($_POST['brand'] ?? 'No disponible'); ?></em></li>
        <li><strong>Modelo:</strong> <em><?php echo htmlspecialchars($_POST['model'] ?? 'No disponible'); ?></em></li>
        <li><strong>Precio:</strong> <em><?php echo htmlspecialchars($_POST['price'] ?? 'No disponible'); ?></em></li>
        <li><strong>Unidades:</strong> <em><?php echo htmlspecialchars($_POST['units'] ?? 'No disponible'); ?></em></li>
    </ul>
    <p><strong>Detalles:</strong> <em><?php echo nl2br(htmlspecialchars($_POST['details'] ?? 'No disponible')); ?></em></p>

    <br>
    <button onclick="mandarTope();">Regresar a la lista por tope</button>
    <button onclick="mandarVigencia();">Regresar a la lista por vigencia</button>
</body>
</html>
