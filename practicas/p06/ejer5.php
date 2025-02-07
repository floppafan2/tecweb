<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica 6 Ejercicio 5</title>
</head>
<body>
    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
    sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
    bienvenida apropiado.</p>
    <p>En caso contrario, deberá devolverse otro mensaje indicando el error.</p>
    <li>Los valores para $edad y $sexo se deben obtener por medio de un formulario en
    HTML.</li>
    <li>Utilizar el la Variable Superglobal $_POST.</li>
    <p>Ingrese su edad y seleccione su sexo.</p>

    <form action="http://localhost/tecweb/practicas/p06/src/func5.php" method="POST">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="1" required>
        <br><br>

        <label>Sexo:</label>
        <input type="radio" id="femenino" name="sexo" value="femenino" required>
        <label for="femenino">Femenino</label>

        <input type="radio" id="masculino" name="sexo" value="masculino">
        <label for="masculino">Masculino</label>
        <br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>