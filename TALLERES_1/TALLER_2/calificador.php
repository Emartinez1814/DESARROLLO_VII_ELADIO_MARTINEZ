<?php
echo "<h2>Ejercicio práctico</h2>";

// se declara la variable con un numero del 0 al 100
$calificacion = 87;
echo "Tu puntuación es: ".$calificacion."<br>";
if ($calificacion >= 90) {
    echo "Tu calificación es A.<br>";
} elseif ($calificacion >= 80) {
    echo "Tu calificación es B.<br>";
} elseif ($calificacion >= 70) {
    echo "Tu calificación es C.<br>";
} elseif ($calificacion >= 60) {
    echo "Tu calificación es D.<br>";
} else {
    echo "Tu calificación es F.<br>";
}
echo "<br>";


// El mismo ejemplo con operador ternario
$resultadoTernario = ($calificacion >= 60) ? "Aprobado" : "Reprobado";
echo "Resultado (ternario): $resultadoTernario<br><br>";

// Ejemplo de switch con expresiones
//$puntuacion = 85;
switch (true) {
    case ($calificacion >= 90):
        echo "Excelente trabajo.<br>";
        break;
    case ($calificacion >= 80):
        echo "Buen trabajo.<br>";
        break;
    case ($calificacion >= 70):
        echo "Trabajo aceptable.<br>";
        break;
    case ($calificacion >= 60):
        echo "Necesita mejorar.<br>";
        break;
    default:
        echo "Debes esforzarte más.<br>";
}
echo "<br>";
?>