<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Registro Completado</title>
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
    <?php
    // Verificar si los datos han sido enviados correctamente
    if (
        isset($_POST['name'], $_POST['brand'], $_POST['model'], $_POST['price'], $_POST['details'], $_POST['units'])
    ) {
        $nombre = trim($_POST['name']);
        $marca  = trim($_POST['brand']);
        $modelo = trim($_POST['model']);
        $precio = floatval($_POST['price']);
        $detalles = trim($_POST['details']);
        $unidades = intval($_POST['units']);

        $uploadDir = "img/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
    
        $imagen = ""; // Se inicializa vacía
    
        // Si se ha subido una imagen, manejar la carga
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES["image"]["tmp_name"];
            $fileName = basename($_FILES["image"]["name"]);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
            $allowedExtensions = ["png"];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                // Generar un nombre único para la imagen
                $imagen = $uploadDir . uniqid() . "." . $fileExtension;
    
                if (move_uploaded_file($fileTmpPath, $imagen)) {
                    echo "<p class='success'> Imagen subida correctamente: $imagen</p>";
                } else {
                    echo "<p class='error'> Error al mover la imagen.</p>";
                    $imagen = ""; // Si falla, se deja vacía
                }
            } else {
                echo "<p class='error'> Formato de imagen no permitido. Solo se aceptan PNG.</p>";
                $imagen = ""; // Si falla, se deja vacía
            }
        } else {
            echo "<p class='error'>⚠ No se subió ninguna imagen o hubo un error.</p>";
            $imagen = "";
        }

        // Conectar a la base de datos
        $link = new mysqli('localhost', 'root', '7*Vl*zwyPeGlNLTm', 'marketzone');
        
        if ($link->connect_errno) {
            die('<p class="error"> Falló la conexión: ' . $link->connect_error . '</p>');
        }
        
        // Establecer el conjunto de caracteres a UTF-8
        $link->set_charset("utf8");

        /*** VALIDACIÓN PARA EVITAR REGISTROS DUPLICADOS ***/
        $sql_check = "SELECT id FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?";
        $stmt_check = $link->prepare($sql_check);
        if ($stmt_check) {
            $stmt_check->bind_param("sss", $nombre, $marca, $modelo);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                echo '<p class="error"> Error: Este producto ya existe en la base de datos.</p>';
                $stmt_check->close();
                $link->close();
                exit();
            }
            $stmt_check->close();
        } else {
            echo '<p class="error"> Error en la consulta de validación.</p>';
            $link->close();
            exit();
        }

        /*** INSERTAR EL PRODUCTO SI NO EXISTE ***/
        
    /*** INSERTAR EL PRODUCTO CON `eliminado = 0` ***/
    $sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
    VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    //$sql_insert = "INSERT INTO productos VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt_insert = $link->prepare($sql_insert);
        if ($stmt_insert) {
            $stmt_insert->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);
            if ($stmt_insert->execute()) {
                echo "<p class='success'> Producto insertado con éxito con ID: " . $stmt_insert->insert_id . "</p>";
            } else {
                echo "<p class='error'> Error al insertar el producto: " . $stmt_insert->error . "</p>";
            }
            $stmt_insert->close();
        } else {
            echo "<p class='error'> Error en la preparación de la consulta de inserción.</p>";
        }

        $link->close();
    } else {
        echo "<p class='error'> Error: Datos incompletos en el formulario.</p>";
        exit();
    }
    ?>

    <h1>Producto agregado</h1>

    <h2>Acerca del producto:</h2>
    <ul>
        <li><strong>Nombre:</strong> <em><?php echo htmlspecialchars($_POST['name'] ?? 'No disponible'); ?></em></li>
        <li><strong>Marca:</strong> <em><?php echo htmlspecialchars($_POST['brand'] ?? 'No disponible'); ?></em></li>
        <li><strong>Modelo:</strong> <em><?php echo htmlspecialchars($_POST['model'] ?? 'No disponible'); ?></em></li>
        <li><strong>Precio:</strong> <em><?php echo htmlspecialchars($_POST['price'] ?? 'No disponible'); ?></em></li>
    </ul>
    <p><strong>Detalles:</strong> <em><?php echo nl2br(htmlspecialchars($_POST['details'] ?? 'No disponible')); ?></em></p>
    <ul>
        <li><strong>Unidades:</strong> <em><?php echo htmlspecialchars($_POST['units'] ?? 'No disponible'); ?></em></li>
    </ul>
    <div>
        <p><strong>Imagen del producto:</strong></p>
        <?php if (isset($imagen)): ?>
            <img src="<?php echo htmlspecialchars($imagen); ?>" width="300" alt="Imagen del producto">
        <?php else: ?>
            <p>No se ha subido ninguna imagen.</p>
        <?php endif; ?>
    </div>

    <p>
        <a href="http://validator.w3.org/check?uri=referer">
            <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88">
        </a>
    </p>

    </body>
</html>
