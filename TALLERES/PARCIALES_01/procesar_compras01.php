<?php
include 'funciones_tienda01.php';

$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
    ];


$subtotal=0;
foreach ($carrito as $producto => $cantidad) {
    $subtotal += $productos[$producto] * $cantidad;
}

echo "la compra es de: $subtotal<br>";
//se calcula el descuento
$descuento=calcular_descuento($subtotal);
//se calcula el impuesto
$impuesto=aplicar_impuesto($subtotal);
//se calcula el total
$compra1=calcular_total($subtotal, $descuento, $impuesto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de la Compra</title>
</head>
<body>
    <h1>Resumen de la Compra Realizada</h1>
    <table border="2">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($carrito as $producto => $cantidad): ?>
            <?php if ($cantidad > 0): ?>
                <tr>
                    <td><?php echo ($producto); ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td><?php echo 'B/.' . $productos[$producto]; ?></td>
                    <td><?php echo 'B/.' . ($productos[$producto] * $cantidad); ?></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <p><strong>Subtotal:</strong> $<?php echo $subtotal; ?></p>
    <p><strong>Descuento aplicado:</strong> $<?php echo $descuento; ?></p>
    <p><strong>Impuesto:</strong> $<?php echo $impuesto; ?></p>
    <p><strong>Total a pagar:</strong> $<?php echo $compra1; ?></p>
</body>
</html>
