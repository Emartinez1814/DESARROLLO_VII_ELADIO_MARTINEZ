<?php
echo "<h2>Ejercicio Práctico</h2>";

echo "<h2>Bucle for</h2>";
// Ejemplo básico de bucle for
echo "Patrón de triángulo rectángulo usando asteriscos (*) :<br>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
       echo "*";
    }
    echo "<br>";
}


echo "<h2>Bucle while</h2>";
// Uso de continue en un bucle while
$j = 0;
echo "Números impares menores que 20 usando(if y continue):<br>";
while ($j < 20) {
    $j++;
    if ($j % 2 == 0) {
        continue;
    }
    echo "$j ";
}
echo "<br><br>";

echo "<h2>Bucle do-while</h2>";

// Ejemplo básico de bucle do-while
$contador = 10;
echo "Contando del 10 al 1 con do-while (if y else):<br>";
do {
    
    if ($contador == 5) {
        $contador--;
        //continue;
    }else{
    echo "$contador ";
    $contador--;
    }
    
} while ($contador >= 1);
    
echo "<br><br>";

?>