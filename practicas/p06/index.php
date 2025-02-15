<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 6</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php
        include_once 'src/funciones.php';
        echo "<h4>Respuesta</h4>";
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            multiplo5y7($num);
        }
    ?>
    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
    secuencia compuesta por: impar, par, impar.</p>
    <p>Estos números deben almacenarse en una matriz de Mx3, donde M es el número de filas y
    3 el número de columnas. Al final muestra el número de iteraciones y la cantidad de
    números generados.</p>
    <?php
        include_once 'src/funciones.php';
        echo "<h4>Respuesta</h4>";
        generarMatriz();
    ?>
    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
    pero que además sea múltiplo de un número dado.</p>
    <li>Crear una variante de este script utilizando el ciclo do-while.</li>
    <li>El número dado se debe obtener vía GET.</li>
    <?php
        include_once 'src/funciones.php';
        if(isset($_GET['num']))
        {
            $n = $_GET['num'];
            echo "<h4>Respuesta</h4>";
            encontrarMultiploWhile($n);
            encontrarMultiploDoWhile($n);
        }
    ?>
    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la a
    a la z. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
    el valor en cada índice.</p>
    <li>Crea el arreglo con un ciclo for</li>
    <li>Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach</li>
    <?php
        include_once 'src/funciones.php';
        generarAscii();
    ?>
    <h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if(isset($_POST["name"]) && isset($_POST["email"]))
        {
            echo $_POST["name"];
            echo '<br>';
            echo $_POST["email"];
        }
    ?>
</body>
</html>