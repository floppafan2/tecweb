<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <?php
        echo '<h4>Respuesta:</h4>'; 
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;

        echo "Valor de a: $a <br>";
        echo "Valor de b: $b <br>";
        echo "Valor de c: $c <br>";

        $a = "PHP server";
        $b = &$a;

        echo "<br>Valor de a: $a <br>";
        echo "Valor de b: $b <br>";
        echo "Valor de c: $c <br>";

        echo "<p>La razon por la que el segundo bloque de respuestas se ve asi es porque el valor de a es PHP server, el
        valor de b y c estan apuntados de la direccion de la variable a.</p>";
        unset($a, $b, $c);
    ?>
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
    verificar la evolución del tipo de estas variables (imprime todos los componentes de los
    arreglo):</p>
    <?php
        error_reporting(0);
        echo '<h4>Respuesta:</h4>'; 
        $a = "PHP5";
        echo "Valor de a: $a <br>";
        $z[] = &$a;
        echo "Valor de z: ";
        print_r($z);
        unset($z);
        $b = "5a version de PHP";
        echo "<br>Valor de b: $b <br>";
        $c = $b*10;
        echo "Valor de c: $c <br>";
        $a .= $b;
        echo "Valor de a: $a <br>";
        $b *= $c;
        echo "Valor de b: $b <br>";
        $z[0] = "MySQL";
        echo "Valor de z: ";
        print_r($z);
    ?>
     <h2>Ejercicio 4</h2>
     <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
     la matriz $GLOBALS o del modificador global de PHP.</p>
     <?php
         echo '<h4>Respuesta:</h4>'; 
         echo "Valor de a: ";
         var_dump($GLOBALS['a']);
         echo "<br>";
         
         echo "Valor de b: ";
         var_dump($GLOBALS['b']);
         echo "<br>";
         
         echo "Valor de c: ";
         var_dump($GLOBALS['c']);
         echo "<br>";
         
         echo "Valor de z: ";
         print_r($GLOBALS['z']);
         unset($a, $b, $c, $z);
     ?>
     <h2>Ejercicio 5</h2>
     <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>
     <?php
        echo '<h4>Respuesta:</h4>'; 
        $a = "7 personas";
        echo "Valor de a: $a <br>";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo "Valor de b: $b <br>";
        echo "Valor de a: $a <br>";
        echo "Valor de c: $c <br>";
        unset($a, $b, $c);
     ?>
</body>
</html>