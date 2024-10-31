<?php
// Definición de variables
$nombre_completo = "Eladio Martinez";
$edad = 36;
$correo = "elado.martinez@utp.ac.pa";
$telefono = "6791-4471";

// Definición de constante
define("OCUPACION", "Estudiante");

// Creación de mensaje usando diferentes métodos de concatenación e impresión
$mensaje1 = "Hola, mi nombre es " . $nombre_completo . " y tengo " . $edad . " años.";   
$mensaje2 = "Mi correo es: ".$correo." mi numero de telefono es: ".$telefono.", y soy " . OCUPACION . ".";

echo $mensaje1 . "<br>";
print($mensaje2 . "<br>");

printf("En resumen: %s, %d años, %s, %s<br>", $nombre_completo, $edad, $correo, $telefono, OCUPACION);

echo "<br>Información de debugging:<br>";
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump(OCUPACION);
echo "<br>";
?>