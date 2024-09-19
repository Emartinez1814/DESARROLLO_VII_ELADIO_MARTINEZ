<?php
function contar_palabras($texto){
    $i = 0;
    $cont = 0;
    $palabra = false;  

    while ($i < strlen($texto)) {

        if ($texto[$i] === ' ') {
            if ($palabra) {
                $palabra = false;
            }
        } else {

            if (!$palabra) {
                $cont++;
                $palabra = true;
            }
        }
        $i++;
    }

    return $cont;
}

$texto = "Eladio Martinez";
$palabras = contar_palabras($texto);
echo "El texto: ".$texto." contiene: ". $palabras." palabras"; 
echo "<br> ";
function contar_vocales($texto) {
    $i = 0;
    $vocales = ['a', 'e', 'i', 'o', 'u'];
    $cont = 0;

    while ($i < strlen($texto)) {
        $caracter = strtolower($texto[$i]);

        if (in_array($caracter, $vocales)) {
            $cont++;
        }
        
        $i++;
    }

    return $cont;
}

$texto = "Eladio Martinez";
$numeroVocales = contar_vocales($texto);
echo "El texto: ".$texto." contiene: ". $numeroVocales." Vocales"; 
echo "<br> ";

function invertir_palabras($texto){

}

?>