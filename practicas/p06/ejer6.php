<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica 6 Ejercicio 6</title>
</head>
<body>
    <h2>Ejercicio 6</h2>
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