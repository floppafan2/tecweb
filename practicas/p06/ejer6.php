<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica 6 Ejercicio 6</title>
</head>
<body>
    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
    una ciudad. Cada vehículo debe ser identificado por:</p>
    <li>Matricula</li>
    <li>Auto
    <li>Marca</li>
    <li>Modelo (año)</li>
    <li>Tipo (sedan|hachback|camioneta)</li></li>
    <li>Propietario
    <li>Nombre</li>
    <li>Ciudad</li>
    <li>Dirección</li></li>
    <p>La matrícula debe tener el siguiente formato LLLNNNN, donde las L pueden ser letras de
    la A-Z y las N pueden ser números de 0-9.</p>
    <p>Para hacer esto toma en cuenta las siguientes instrucciones:</p>
    <li>Crea en código duro el registro para 15 autos</li>
    <li>Utiliza un único arreglo, cuya clave de cada registro sea la matricula</li>
    <li>Lógicamente la matricula no se puede repetir.</li>
    <li>Los datos del Auto deben ir dentro de un arreglo.</li>
    <li>Los datos del Propietario deben ir dentro de un arreglo.</li>
    <p>Consulta los vehículos ingresando una matrícula o mostrando todos los registros.</p>
<?php
    include 'src/func6.php';
?>
    <form action="ejer6.php" method="POST">
        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula" pattern="[A-Z]{3}[0-9]{4}" placeholder="Ej: ABC1234">
        <br><br>

        <button type="submit" name="consulta" value="uno">Buscar Matrícula</button>
        <button type="submit" name="consulta" value="todos">Mostrar Todos</button>
    </form>

    <br>
    <h2>Resultados</h2>
    <?php echo $mensaje; ?>
</body>
</html>