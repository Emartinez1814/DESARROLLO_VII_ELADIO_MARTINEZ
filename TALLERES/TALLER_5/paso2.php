<?php
// 1. Crear un arreglo asociativo de productos con su inventario
$inventario = [
    "laptop" => ["cantidad" => 50, "precio" => 800],
    "smartphone" => ["cantidad" => 100, "precio" => 500],
    "tablet" => ["cantidad" => 30, "precio" => 300],
    "smartwatch" => ["cantidad" => 25, "precio" => 150]
];

// 2. Función para mostrar el inventario
function mostrarInventario($inv) {
    foreach ($inv as $producto => $info) {
        echo "$producto: {$info['cantidad']} unidades, Precio: {$info['precio']}\n";
        echo "<br>";
    }
}

// 3. Mostrar inventario inicial
echo "Inventario inicial:\n";
echo "<br>";
mostrarInventario($inventario);

// 4. Función para actualizar el inventario
function actualizarInventario(&$inv, $producto, $cantidad, $precio = null) {
    if (!isset($inv[$producto])) {
        $inv[$producto] = ["cantidad" => $cantidad, "precio" => $precio];
    } else {
        $inv[$producto]["cantidad"] += $cantidad;
        if ($precio !== null) {
            $inv[$producto]["precio"] = $precio;
        }
    }
    
}

// 5. Actualizar inventario
actualizarInventario($inventario, "laptop", -5);  // Venta de 5 laptops
actualizarInventario($inventario, "smartphone", 50, 450);  // Nuevo lote de smartphones con precio actualizado
actualizarInventario($inventario, "auriculares", 100, 50);  // Nuevo producto
echo "<br>";
// 6. Mostrar inventario actualizado
echo "\nInventario actualizado:\n";
echo "<br>";
mostrarInventario($inventario);

// 7. Función para calcular el valor total del inventario
function valorTotalInventario($inv) {
    $total = 0;
    foreach ($inv as $producto => $info) {
        $total += $info['cantidad'] * $info['precio'];
    }
    return $total;
}
echo "<br>";
// 8. Mostrar valor total del inventario
echo "\nValor total del inventario: $" . valorTotalInventario($inventario) . "\n";
echo "<br>";
// 9. Función para encontrar el producto con el mayor valor total en inventario
function inventarioReal($inv) {
    $productoMayorValor = null;
    $mayorValor = 0;

    foreach ($inv as $producto => $info) {
        $valorTotal = $info['cantidad'] * $info['precio'];
        
        if ($valorTotal > $mayorValor) {
            $mayorValor = $valorTotal;
            $productoMayorValor = $producto;
        }
    }

    return $productoMayorValor;
}

// Mostrar producto con mayor valor en inventario
$productoMayor = inventarioReal($inventario);
echo "\nEl producto con el mayor valor total en inventario es: $productoMayor\n";
echo "<br>";
echo "Cantidad: " . $inventario[$productoMayor]['cantidad'] . "\n";
echo "<br>";
echo "Precio: " . $inventario[$productoMayor]['precio'] . "\n";
echo "<br>";
echo "Valor Total: " . ($inventario[$productoMayor]['cantidad'] * $inventario[$productoMayor]['precio']) . "\n";
?>