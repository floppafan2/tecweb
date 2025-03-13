<?php
require 'database.php'; // Archivo que contiene la conexión a la base de datos

if (isset($_POST['name'])) {
    $name = trim($_POST['name']);
    
    $stmt = $conexion->prepare("SELECT COUNT(*) FROM productos WHERE nombre = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    echo json_encode(["exists" => $count > 0]);
} else {
    echo json_encode(["error" => "No se recibió un nombre de producto válido."]);
}
?>
