<?php
require_once "config_mysqli.php";

// 1. Productos que tienen un precio mayor al promedio de su categoría
$sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
        (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (
            SELECT AVG(precio)
            FROM productos 
            WHERE categoria_id = p.categoria_id
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: \${$row['precio']}, ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: \${$row['promedio_categoria']}<br>";
    }
    mysqli_free_result($result);
}

// 2. Clientes con compras superiores al promedio
$sql = "SELECT c.nombre, c.email,
        (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
        (SELECT AVG(total) FROM ventas) as promedio_ventas
        FROM clientes c
        WHERE (
            SELECT SUM(total)
            FROM ventas
            WHERE cliente_id = c.id
        ) > (
            SELECT AVG(total)
            FROM ventas
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: \${$row['total_compras']}, ";
        echo "Promedio general: \${$row['promedio_ventas']}<br>";
    }
    mysqli_free_result($result);
}

//3.productos  que nunca se han vendido
$sql = "SELECT p.nombre, p.precio, v.id
    FROM productos p
    LEFT JOIN ventas v ON p.id = v.id 
    WHERE v.id IS NULL";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: \${$row['precio']}<br>";
    }
    mysqli_free_result($result);

}


$sql = "    SELECT c.nombre AS categoria, COUNT(p.id) AS num_productos, SUM(p.precio * p.stock) AS valor_inventario
    FROM categorias c
    JOIN productos p ON p.categoria_id = c.id
    GROUP BY c.id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['num_productos']}, Valor total del inventario: \${$row['valor_inventario']}<br>";
    }
    mysqli_free_result($result);
}

$categoria_id = 3; 

$sql = "    SELECT c.id AS cliente_id, c.nombre, c.email
    FROM clientes c
    WHERE NOT EXISTS (
        SELECT 1
        FROM productos p
        WHERE p.categoria_id = ?
        AND NOT EXISTS (
            SELECT 1
            FROM detalles_venta dv
            JOIN ventas v ON v.id = dv.venta_id
            WHERE dv.producto_id = p.id
            AND v.cliente_id = c.id
            AND v.estado = 'completada' -- Asegura que la venta haya sido completada
        )
    )";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $categoria_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    echo "<h3>Clientes que han comprado todos los productos de la categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Email: {$row['email']}<br>";
    }
    mysqli_free_result($result);
}

$sql_porcentaje_ventas = "    SELECT p.nombre, SUM(v.total) AS ventas_producto, 
           (SUM(v.total) / (SELECT SUM(total) FROM ventas)) * 100 AS porcentaje_ventas
    FROM productos p
    JOIN ventas v ON p.id = v.id
    GROUP BY p.id";

$result_porcentaje_ventas = mysqli_query($conn, $sql_porcentaje_ventas);

if ($result_porcentaje_ventas) {
    echo "<h3>Porcentaje de ventas de cada producto:</h3>";
    while ($row = mysqli_fetch_assoc($result_porcentaje_ventas)) {
        echo "Producto: {$row['nombre']}, Ventas: \${$row['ventas_producto']}, Porcentaje de ventas: {$row['porcentaje_ventas']}%<br>";
    }
    mysqli_free_result($result_porcentaje_ventas);
}

mysqli_close($conn);
?>