<?php 

if (isset($_POST['contactos'])){
    // Recuperamos los contactos del input hidden
    $contactos = json_decode($_POST['contactos'], true);
}
else {
    $contactos = [];
}

// Variables
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];

$contacto = [
    'nombre' => $nombre,
    'telefono' => $telefono
];

if ($nombre === "") {
    echo 'El nombre no puede estar vacío';
}
else if (($nombre !== "") && ($telefono !== "")) {
    $nombreEncontrado = false;
    foreach ($contactos as $indice => $contactoExistente) {
        if ($contactoExistente['nombre'] === $nombre) {
            $nombreEncontrado = true;  //Se encuenta el nombre  
        
            if ($nombreEncontrado){
                // Si hay coincidencia de nombre, se actualiza el telefono
                $contactos[$indice]['telefono'] = $telefono; 
            }        
        }
    }
    //Agregamos el nuevo contacto si no está repetido
    if(!$nombreEncontrado){
    $contactos[] = $contacto;
    }
}
else {
    $nombreEncontrado = false;
    foreach ($contactos as $indice => $contactoExistente) {
        if ($contactoExistente['nombre'] === $nombre) {
            $nombreEncontrado = true;
           if ($nombreEncontrado){
            unset($contactos[$indice]);
            }
        }
    }
}


// Devolvemos los contactos actualizados
echo json_encode($contactos);



?>