<?php
// 1. Crear un string JSON con datos de una tienda en línea
$jsonDatos = '
{
    "tienda": "ElectroTech",
    "productos": [
        {"id": 1, "nombre": "Laptop Gamer", "precio": 1200, "categorias": ["electrónica", "computadoras"]},
        {"id": 2, "nombre": "Smartphone 5G", "precio": 800, "categorias": ["electrónica", "celulares"]},
        {"id": 3, "nombre": "Auriculares Bluetooth", "precio": 150, "categorias": ["electrónica", "accesorios"]},
        {"id": 4, "nombre": "Smart TV 4K", "precio": 700, "categorias": ["electrónica", "televisores"]},
        {"id": 5, "nombre": "Tablet", "precio": 300, "categorias": ["electrónica", "computadoras"]}
    ],
    "clientes": [
        {"id": 101, "nombre": "Ana López", "email": "ana@example.com"},
        {"id": 102, "nombre": "Carlos Gómez", "email": "carlos@example.com"},
        {"id": 103, "nombre": "María Rodríguez", "email": "maria@example.com"}
    ]
}
';

// 2. Convertir el JSON a un arreglo asociativo de PHP
$tiendaData = json_decode($jsonDatos, true);

// 3. Función para imprimir los productos
function imprimirProductos($productos) {
    foreach ($productos as $producto) {
        echo "{$producto['nombre']} - $".$producto['precio']." - Categorías: " . implode(", ", $producto['categorias']) . "<br>";
    }
}

echo "Productos de {$tiendaData['tienda']}:<br>";
imprimirProductos($tiendaData['productos']);

// 4. Calcular el valor total del inventario
$valorTotal = array_reduce($tiendaData['productos'], function($total, $producto) {
    return $total + $producto['precio'];
}, 0);

echo "<br>Valor total del inventario: $$valorTotal<br>";

// 5. Encontrar el producto más caro
$productoMasCaro = array_reduce($tiendaData['productos'], function($max, $producto) {
    return ($producto['precio'] > $max['precio']) ? $producto : $max;
}, $tiendaData['productos'][0]);

echo "Producto más caro: {$productoMasCaro['nombre']} -$".$productoMasCaro['precio'];

// 6. Filtrar productos por categoría
function filtrarPorCategoria($productos, $categoria) {
    return array_filter($productos, function($producto) use ($categoria) {
        return in_array($categoria, $producto['categorias']);
    });
}

$productosDeComputadoras = filtrarPorCategoria($tiendaData['productos'], "computadoras");
echo "<br>Productos en la categoría 'computadoras':<br>";
imprimirProductos($productosDeComputadoras);

// 7. Agregar un nuevo producto
$nuevoProducto = [
    "id" => 6,
    "nombre" => "Smartwatch",
    "precio" => 250,
    "categorias" => ["electrónica", "accesorios", "wearables"]
];
$tiendaData['productos'][] = $nuevoProducto;

// 8. Convertir el arreglo actualizado de vuelta a JSON
$jsonActualizado = json_encode($tiendaData, JSON_PRETTY_PRINT);
echo "<br>Datos actualizados de la tienda (JSON):<br>$jsonActualizado<br>";

// TAREA: Implementa una función que genere un resumen de ventas
// Crea un arreglo de ventas (producto_id, cliente_id, cantidad, fecha)
// y genera un informe que muestre:
// - Total de ventas
// - Producto más vendido
// - Cliente que más ha comprado
// Tu código aquí

$ventas = [
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2023-09-01"],
    ["producto_id" => 2, "cliente_id" => 102, "cantidad" => 2, "fecha" => "2023-09-03"],
    ["producto_id" => 3, "cliente_id" => 103, "cantidad" => 3, "fecha" => "2023-09-05"],
    ["producto_id" => 1, "cliente_id" => 101, "cantidad" => 1, "fecha" => "2023-09-07"],
    ["producto_id" => 5, "cliente_id" => 102, "cantidad" => 1, "fecha" => "2023-09-08"],
];

// Función para generar el informe de ventas
function generarInformeVentas($ventas, $productos, $clientes) {
    $totalVentas = 0;
    $productosVendidos = [];
    $ventasPorCliente = [];

    foreach ($ventas as $venta) {
        // Sumar el total vendido (precio * cantidad)
        $productoId = $venta["producto_id"];
        $cantidad = $venta["cantidad"];

        // Encontrar el producto
        $producto = array_filter($productos, function($p) use ($productoId) {
            return $p["id"] == $productoId;
        });
        $producto = reset($producto); // Obtener el primer elemento del resultado

        $totalVentas += $producto["precio"] * $cantidad;

        // Llevar cuenta de productos vendidos
        if (!isset($productosVendidos[$productoId])) {
            $productosVendidos[$productoId] = 0;
        }
        $productosVendidos[$productoId] += $cantidad;

        // Llevar cuenta de ventas por cliente
        $clienteId = $venta["cliente_id"];
        if (!isset($ventasPorCliente[$clienteId])) {
            $ventasPorCliente[$clienteId] = 0;
        }
        $ventasPorCliente[$clienteId] += $producto["precio"] * $cantidad;
    }

    // Producto más vendido
    $productoMasVendidoId = array_keys($productosVendidos, max($productosVendidos))[0];
    $productoMasVendido = array_filter($productos, function($p) use ($productoMasVendidoId) {
        return $p["id"] == $productoMasVendidoId;
    });
    $productoMasVendido = reset($productoMasVendido);

    // Cliente que más ha comprado
    $clienteMasCompradorId = array_keys($ventasPorCliente, max($ventasPorCliente))[0];
    $clienteMasComprador = array_filter($clientes, function($c) use ($clienteMasCompradorId) {
        return $c["id"] == $clienteMasCompradorId;
    });
    $clienteMasComprador = reset($clienteMasComprador);

    // Retornar informe
    return [
        "total_ventas" => $totalVentas,
        "producto_mas_vendido" => $productoMasVendido,
        "cliente_mas_comprador" => $clienteMasComprador,
    ];
}

// Generar el informe de ventas
$informeVentas = generarInformeVentas($ventas, $tiendaData['productos'], $tiendaData['clientes']);

// Mostrar el informe
echo "<br>Informe de ventas:<br>";
echo "Total de ventas: $" . $informeVentas["total_ventas"] . "<br>";
echo "Producto más vendido: " . $informeVentas["producto_mas_vendido"]["nombre"] . "<br>";
echo "Cliente que más ha comprado: " . $informeVentas["cliente_mas_comprador"]["nombre"] . "<br>";


?>