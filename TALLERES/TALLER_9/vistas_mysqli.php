<?php
require_once "config_mysqli.php";

function mostrarResumenCategorias($conn) {
    $sql = "SELECT * FROM vista_resumen_categorias";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Resumen por Categorías:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Stock Total</th>
            <th>Precio Promedio</th>
            <th>Precio Mínimo</th>
            <th>Precio Máximo</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_productos']}</td>";
        echo "<td>{$row['total_stock']}</td>";
        echo "<td>\${$row['precio_promedio']}</td>";
        echo "<td>\${$row['precio_minimo']}</td>";
        echo "<td>\${$row['precio_maximo']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarProductosPopulares($conn) {
    $sql = "SELECT * FROM vista_productos_populares LIMIT 5";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Top 5 Productos Más Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Compradores Únicos</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['producto']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_vendido']}</td>";
        echo "<td>\${$row['ingresos_totales']}</td>";
        echo "<td>{$row['compradores_unicos']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//vista de bajo stock menores de 20
function mostrarProductosBajoStock($conn) {
    $sql = "SELECT * FROM vista_producto_bajo_stock";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Productos menores a 20 unidades en stock:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre del Producto</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Total Vendido</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['nombre_del_producto']}</td>";
        echo "<td>{$row['precio']}</td>";
        echo "<td>{$row['stock']}</td>";
        echo "<td>{$row['total_vendido']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//Historial completo de clientes
function mostrarHistorialCliente($conn) {
    $sql = "SELECT * FROM historial_completo_clientes";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Historial de compra del cliente:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Nombre del Cliente</th>
            <th>Email</th>
            <th>Fecha de Venta</th>
            <th>Estado</th>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Monto Total</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['cliente_nombre']}</td>";
        echo "<td>{$row['cliente_email']}</td>";
        echo "<td>{$row['fecha_venta']}</td>";
        echo "<td>{$row['venta_estado']}</td>";
        echo "<td>{$row['producto_nombre']}</td>";
        echo "<td>{$row['cantidad']}</td>";
        echo "<td>{$row['precio_unitario']}</td>";
        echo "<td>{$row['monto_total']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//rendimiento por Categoria
function mostrarRendimientoCategorias($conn) {
    $sql = "SELECT * FROM vista_rendimiento_categorias";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Rendimiento de Categorias:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoria</th>
            <th>Total de Productos</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Producto mas Vendido</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_productos']}</td>";
        echo "<td>{$row['total_vendido']}</td>";
        echo "<td>{$row['ingresos_totales']}</td>";
        echo "<td>{$row['producto_mas_vendido']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//Tendencia de ventas por mes
function mostrarTendenciaVentaPorMes($conn) {
    $sql = "SELECT * FROM vista_tendencias_ventas_mensuales";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Tendencia de Ventas por Mes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Mes de Venta</th>
            <th>Total de Ventas</th>
            <th>Ingresos Totales</th>
            <th>Promedio de Ventas</th>
            <th>Venta de Mes Anterior</th>
            <th>Variacion de venta</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['mes']}</td>";
        echo "<td>{$row['total_ventas']}</td>";
        echo "<td>{$row['ingresos_totales']}</td>";
        echo "<td>{$row['promedio_venta']}</td>";
        echo "<td>{$row['ingresos_mes_anterior']}</td>";
        echo "<td>{$row['variacion_ingresos']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

// Mostrar los resultados
mostrarResumenCategorias($conn);
mostrarProductosPopulares($conn);
mostrarProductosBajoStock($conn);
mostrarHistorialCliente($conn);
mostrarRendimientoCategorias($conn);
mostrarTendenciaVentaPorMes($conn);

mysqli_close($conn);
?>