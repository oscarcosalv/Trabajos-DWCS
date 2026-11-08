<!--
    • R2. Validación. Se comprueba en el servidor y se muestran todos los errores a la vez, con un mensaje que
diga cuál es el problema:
        ◦ filas y columnas fuera de rango o no numéricas;
        ◦ un número impar de cartas (filas × columnas): con 3 × 3 hay 9 cartas y no se pueden hacer parejas;
        ◦ letras que no sean de la A a la Z (sin espacios, tildes ni ñ), letras repetidas (indicando cuáles) o menos
letras que parejas (con 2 × 3 hacen falta al menos 3 letras);
        ◦ fallos permitidos fuera de rango.
      Las letras se pasan a mayúsculas y se quitan los espacios de los extremos. Si sobran letras, se usan las
primeras. Si hay errores, el formulario conserva lo escrito (formulario pegajoso).
-->

<?php
    //Variables sacadas del formulario
    $filas = $_POST['filas'];
    $columnas = $_POST['columnas'];
    $letrasCartas = trim(strtoupper($_POST['letrasCarta'])); //en mayúsculas y sin espacios
    $fallos = $_POST['fallos'];


    //R2 Validación
    //Comprobar filas o columnas fuera de rango
    if (($filas < 2 || $filas > 6) || ($columnas < 2 || $columnas > 6)){
        echo "Filas o columnas están fuera de rango o no son un número.";
    }

    //Numero impar de filas y columnas
    if (($filas %2 != 0) && ($columnas %2 !=0)){
        echo "Numero impar de cartas, no se pueden hacer parejas";
    }

    //Funcion para que no se repitan las letras
    function letrasUnicas($letras){
        for ($i = 0; $i < strlen($letras); $i ++){
            for ($j = $i + 1; $j < strlen($letras); $j ++){
                if ($letras[$i] === $letras[$j]){
                    echo "La letra $letras[$i] está repetida.";
                }
            }
        }
    }

    //Comprobar que no se repiten las letras
    letrasUnicas($letrasCartas);

    //Funcion para saber que hacen falta más letras para las parejas
    function notEnoughLetters(){
        global $filas;
        global $columnas;
        global $letrasCartas;

        if (($filas * $columnas) > (strlen($letrasCartas) * 2)){
            echo "Faltan letras para las parejas";
        }
    }

    //Comprobar que no se repitan las parejas
    notEnoughLetters();

    //Fallos permitidos fuera de rango
    function fallosRango(){
        if ($_POST['fallos'] > 30 || $_POST['fallos'] < 1){
            echo "El número de fallos permitidos tiene que ser entre 1 y 30";
        }
    }

    //Llamar a la función del rango de fallos
    fallosRango();

    //Funcion para retirar letras sobrantes
    function quitaLetras($letras){
        global $filas;
        global $columnas;

        $celdas = ($filas * $columnas);
        $numLetras = strlen($letras);
        if ($celdas > ($numLetras * 2)){
            $cant = $celdas / 2;
            $letras = substr($letras, 0 , $cant);
        } 
        
        return $letras;
    }

    //Cortar letras sobrantes;
    quitaLetras($letrasCartas);

    // R3 generar tablero
    function crearTablero(){
        global $filas;
        global $columnas;
        global $letrasCartas;

        //Crear el tablero como un array con las filas y columnas
        $tablero = [];
        //Y tambien otro llamado cartas, que tendrá el valor real
        $cartas = [];

        $puntuacion = 0;
        $contFallos = 0;

        for ($i = 0; $i < $filas; $i++){
            for ($j = 0; $j < $columnas; $j++){

                
                $tablero[$i][$j] = "?"; //Colocamos un interrogante en cada celda
                $cartas[] = $tablero[$i][$j]; //Tenemos las cartas con la misma cantidad de celdas que el tablero

                //Cada celda es una carta, y se le da una letra
                $totalLetras = str_split($letrasCartas.$letrasCartas); //Duplica cada letra para que haya parejas


                foreach ($cartas as $carta){
                    $carta = ""; //Vaciamos el valor de cada unidad
                }

                for ($a = 0; $a < count($totalLetras); $a++){
                    $letraAsignada = $totalLetras[$a];

                    //Cada carta se crea como un botón
                    $carta = "<button type='submit' name='carta' value='$i'.'-'.'$j'>";
                    $carta .= $letraAsignada;
                    $carta .= "</button>";
                }
            }
        }
        
        shuffle($cartas); //Baraja las cartas
        array_chunk($cartas, $columnas); //Las reparte en filas

        //Pone cada botón de carta en su correspondiente posición
        foreach($cartas as $carta){
            echo $carta;
        }

        //Guarda el tablero inicial en el campo oculto
        return [$tablero, $cartas];
    }
    
    function primerMov(){

        //Recuperar los valores del campo oculto del tablero creado
        $tablero = json_decode($_POST['setTablero'], true);
        $cartas = json_decode($_POST['setCartas'], true);

        //Muestra el tablero con las ?
        echo $tablero;

        //Muestra la letra de la carta
        if (isset($_POST['carta'])) {
            $posicion = explode("-", $_POST['carta']);

            $i = $posicion[0];
            $j = $posicion[1];

            $letra1 = $cartas[$i][$j];
            $priCartas = $cartas[$i][$j];

            echo $letra1;
        }

        return $priCartas;

    }

    function emparejar(){

        //Recupera las cartas del primer movimiento
        $cartas = json_decode($_POST['priCartas'], true);
        global $letra1;
        global $letrasCartas;
        global $puntuacion;
        global $contFallos;

        //Siguiente movimiento
        if (isset($_POST['carta'])) {
            $posicion = explode("-", $_POST['carta']);

            $a = $posicion[0];
            $b = $posicion[1];

            $letra2 = $cartas[$a][$b];
            
            if ($letra1 === $letra2){
                echo "¡Pareja de $letra1! +10 puntos.". "<br>";
                echo "Pareja 1 de ".strlen($letrasCartas);
                $puntuacion += 10;
            }
            else {
                echo "No son pareja $letra1, $letra2";
                $puntuacion -= 2;
                $contFallos += 1;
            }
            
        }
    }
?>