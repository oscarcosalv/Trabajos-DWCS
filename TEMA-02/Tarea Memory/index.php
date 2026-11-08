<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory</title>
</head>

<body>
    <form action="funciones.php" method ="post">
        <h3>Tablero</h3>
        <label>Nº de filas (de 2 al 6)</label>
        <input type="number" min="2" max="6" name="filas" value=<?php echo htmlspecialchars($_POST['filas'] ?? '4');?> required>
        <br>
        <label>Nº de columnas (de 2 a 6)</label>
        <input type="number" min="2" max="6" name ="columnas" value=<?php echo htmlspecialchars($_POST['columnas'] ?? '4');?> required>
        <br>
        <h3>Letras de las cartas</h3>
        <label>Introduce las letras de las cartas</label>
        <input type="text" pattern="[A-Z]" name="letrasCarta" value=<?php echo htmlspecialchars($_POST['letrasCarta'] ?? 'ABCDEFGH');?> required>
        <br>
        <h3>Nº de fallos permitidos</h3>
        <label>Nº de fallos (de 1 a 30)</label>
        <input type="number" min="1" max="30" name="fallos" value=<?php echo htmlspecialchars($_POST['fallos'] ?? '8');?> required>
        <br>
        <input type="submit" value="Empezar">
        <input type="reset" value="Borrar">

    </form>

    <div id="tablero">
        <?php 
            include "funciones.php";

            [$tablero, $cartas] = crearTablero();
            [$priCartas] = primerMov();
        ?>
        <form>

        <input type="hidden" name="setTablero" value="<?php echo htmlspecialchars(json_encode($tablero)); ?>">
        <input type="hidden" name="setCartas" value="<?php echo htmlspecialchars(json_encode($cartas)); ?>">
        <input type="hidden" name="priCartas" value="<?php echo htmlspecialchars(json_encode($priCartas)); ?>">

        </form>
    </div>
</body>
</html>

