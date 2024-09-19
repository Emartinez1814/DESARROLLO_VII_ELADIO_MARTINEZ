<?php
function calcular_descuento($total_compra){
//$calificacion = 485;
if ($total_compra >= 1000) {
    $monto=$total_compra-($total_compra*0.15);
    echo "aplica un 15% de descuento es igual $monto <br>";
} elseif ($total_compra >= 501) {
    $monto=$total_compra*0.10;
    echo "aplica un 10% de descuento es igual $monto<br>";
} elseif ($total_compra >= 100) {
    $monto=$total_compra*0.05;
    echo "aplica un 5% de descuento es igual $monto<br>";
} else {
    echo "no hay descuento.<br>";
}
return $monto;
}
function aplicar_impuesto($subtotal){

$compra=$subtotal*0.07;
echo "se aplica el impuesto del 7% queda en = $compra<br>";
return $compra;
}

function calcular_total($subtotal, $descuento, $impuesto){
$total=$subtotal-$descuento+$impuesto;
echo "la compra Total es: $total<br>";
return $total;
}
?>