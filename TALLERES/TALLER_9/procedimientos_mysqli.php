<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para devolucion de venta
function devolucionVenta($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL procesar_devolucion(?,?,?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        
        //$result = mysqli_query($conn, $venta_id);
        //$row = mysqli_fetch_assoc($result);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        echo "DEVOLUCION registrada con éxito. ID de venta: " . $venta_id;
       // echo "DEVOLUCION registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la DEVOLUCION: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para aplicar los descuentos 
function aplicarDescuento($conn,$cliente_id, $venta_id) {
    $query = "CALL aplicar_descuento_historial(?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"ii", $cliente_id, $venta_id);
    
    try {
        mysqli_stmt_execute($stmt);
        
        
        //$result = mysqli_query($conn, $venta_id);
        //$row = mysqli_fetch_assoc($result);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        echo "DESCUNTO registrada con éxito. ID de venta: " . $venta_id;
    } catch (Exception $e) {
        echo "Error al registrar la DESCUENTO: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para generar reporte de los bajo stock
function generarReporteBajoStock($conn,$stock_minimo) {
    $query = "CALL generar_reporte_bajo_stock(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"i", $stock_minimo);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        echo "<h3>Reporte de Bajo Stock</h3>";
        echo "ID: " . $row['producto_id'] . "<br>";
        echo "Mombre: " . $row['producto'] . "<br>";
        echo "Stock Actual: " . $row['stock_actual'] . "<br>";
        echo "Sugerencia de Stock:" . $row['cantidad_reposicion_sugerida']  . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

// Función para calcular comisiones
function calcularComisiones($conn,$porcentajeComisionMonto, $comisionPorProducto) {
    $query = "CALL calcular_comisiones_por_criterios(?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"ii", $porcentajeComisionMonto, $comisionPorProducto);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        echo "<h3>Reporte de Comisiones Calculadas por Venta</h3>";
        echo "ID de la Venta: " . $row['venta_id'] . "<br>";
            echo "ID del Cliente: " . $row['cliente_id'] . "<br>";
            echo "Total de Venta: " . $row['total_venta'] . "<br>";
            echo "Total de Productos Vendidos: " . $row['total_productos_vendidos'] . "<br>";
            echo "Comisión por Monto: " . $row['comision_por_monto'] . "<br>";
            echo "Comisión por Producto: " . $row['comision_por_producto'] . "<br>";
            echo "Comisión Total: " . $row['comision_total'] . "<br><br>";
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {   
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

// Ejemplos de uso, las funciones estan comentados para no ejecutarlos
//registrarVenta($conn, 4, 2, 1);
//devolucionVenta($conn,7,1,2);
aplicarDescuento($conn,1, 5);
generarReporteBajoStock($conn,20);
calcularComisiones($conn,4,2);
obtenerEstadisticasCliente($conn, 1);

mysqli_close($conn);
?>