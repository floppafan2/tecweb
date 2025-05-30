<?php
    function multiplo5y7($num){ //Ejercicio 1
        if ($num%5==0 && $num%7==0){
            echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
        }
        else{
            echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
        }
    }
    function generarMatriz() { //Ejercicio 2
        $matriz = [];
        $iteraciones = 0;
        $totalNumeros = 0;
        
        do {
            $num1 = rand(100, 999); 
            $num2 = rand(100, 999);
            $num3 = rand(100, 999);
            $totalNumeros += 3;
            
            $matriz[] = [$num1, $num2, $num3];
            $iteraciones++;
            
        } while (!($num1 % 2 == 1 && $num2 % 2 == 0 && $num3 % 2 == 1));

        echo "<table border='1'>";
        echo "<tr><th>Número 1</th><th>Número 2</th><th>Número 3</th></tr>";
        foreach ($matriz as $fila) {
            echo "<tr><td>{$fila[0]}</td><td>{$fila[1]}</td><td>{$fila[2]}</td></tr>";
        }
        echo "</table>";

        echo "<br>$totalNumeros números obtenidos en $iteraciones iteraciones<br>";
    }
    function encontrarMultiploWhile($numeroDado) { //Ejercicio 3
        $numeroAleatorio = rand(1, 1000);
        while ($numeroAleatorio % $numeroDado !== 0) {
            $numeroAleatorio = rand(1, 1000);
        }
        echo "<h4>Usando while:</h4>";
        echo "Primer múltiplo de: $numeroDado ,encontrado es: $numeroAleatorio <br>"; 
    }
    function encontrarMultiploDoWhile($numeroDado) {
        do {
            $numeroAleatorio = rand(1, 1000);
        } while ($numeroAleatorio % $numeroDado !== 0);
        echo "<h4>Usando do-while:</h4>";
        echo "Primer múltiplo de: $numeroDado ,encontrado es: $numeroAleatorio <br>";
    }
    function generarAscii() { //Ejercicio 4
        $asciiArray = [];
        for ($i = 97; $i <= 122; $i++) {
            $asciiArray[$i] = chr($i);
        }
        echo "<table border='1'>";
        echo "<tr><th>Índice ASCII</th><th>Letra</th></tr>";
        foreach ($asciiArray as $indice => $letra) {
            echo "<tr><td>$indice</td><td>$letra</td></tr>";
        }
        echo "</table>";
    }
?>