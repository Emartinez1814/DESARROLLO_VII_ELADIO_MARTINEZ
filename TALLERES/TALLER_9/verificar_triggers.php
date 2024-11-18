<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

function verificarCambiosPrecio($pdo, $producto_id, $nuevo_precio) {
    try {
        // Actualizar precio
        $stmt = $pdo->prepare("UPDATE productos SET precio = ? WHERE id = ?");
        $stmt->execute([$nuevo_precio, $producto_id]);
        
        // Verificar log de cambios
        $stmt = $pdo->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($pdo, $producto_id, $nueva_cantidad) {
    try {
        // Actualizar stock
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);
        
        // Verificar movimientos de inventario
        $stmt = $pdo->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->execute([$producto_id]);
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
// funcion para dar estadistica de las categorias de acuerdo a la venta
function obtenerEstadisticasVentasPorCategoria($pdo) {
    try {
        // Verificar estadistica
        $stmt = $pdo->prepare("
            SELECT e.categoria_id, c.nombre AS categoria_nombre, e.total_ventas
            FROM estadisticas_ventas_por_categoria e
            JOIN categorias c ON e.categoria_id = c.id
        ");
        $stmt->execute();
        $estadisticas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Estadistica de ventas por Categoria:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Categoría</th><th>Total de Ventas</th></tr>";
        foreach($estadisticas as $fila){
        echo "<tr>";
        echo "<td> " . $fila['categoria_nombre'] . "</td>";
        echo "<td>" . $fila['total_ventas'] . "</td>";
        echo "</tr>";
        }   
        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// funcion para dar estadistica de las categorias de acuerdo a la venta
function obtenerAlertaStockCritico($pdo) {
    try {
        // Verificar estadistica
        $stmt = $pdo->prepare("
            SELECT a.id, p.nombre AS nombre_producto, a.mensaje,p.stock, a.fecha_alerta
                FROM alertas_stock a
                JOIN productos p ON a.producto_id = p.id
                ORDER BY a.fecha_alerta DESC
        ");
        $stmt->execute();
        $alerta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Alerta de Stock de Nivel Critico Menores de 5 unidades:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre de Producto</th>
        <th>Mensaje</th>
        <th>Fecha de Alerta</th>
        </tr>";
        foreach($alerta as $fila){
        echo "<tr>";
        echo "<td> " . $fila['nombre_producto'] . "</td>";
        echo "<td>" . $fila['mensaje'] . "</td>";
        echo "<td>" . $fila['fecha_alerta'] . "</td>";
        echo "</tr>";
        }   
        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// funcion para llevar el historial del estado del cliente
function obtenerHistorialEstadoCliente($pdo) {
    try {
        // Verificar estadistica
        $stmt = $pdo->prepare("
           SELECT h.id, h.cliente_id, c.nombre AS nombre_cliente, 
                       h.estado_anterior, h.estado_nuevo, h.fecha_cambio
                FROM historial_estado_clientes h
                JOIN clientes c ON h.cliente_id = c.id
                ORDER BY h.fecha_cambio DESC
        ");
        $stmt->execute();
        $estado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Historial de Estado del Cliente:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre del Cliente</th>
        <th>Estado Anterior</th>
        <th>Estado Nuevo</th>
        <th>Fecha de Cambio</th>
        </tr>";
        foreach($estado as $fila){
             // Convertir valores booleanos a texto
             $estadoAnterior = $fila['estado_anterior'] ? 'Activo' : 'Inactivo';
             $estadoNuevo = $fila['estado_nuevo'] ? 'Activo' : 'Inactivo';
        echo "<tr>";
        echo "<td> " . $fila['nombre_cliente'] . "</td>";
        echo "<td>" . $estadoAnterior. "</td>";
        echo "<td>" . $estadoNuevo. "</td>";
        echo "<td>" . $fila['fecha_cambio'] . "</td>";
        echo "</tr>";
        }   
        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// funcion para mostrar el estado del cliente en la menbresia
function obtenerTotalVentasPorCliente($pdo) {
    try {
        // Verificar estadistica
        $stmt = $pdo->prepare("
           SELECT SUM(v.total) AS total, c.nombre AS nombre_cliente,c.nivel_membresia as estado
                FROM ventas v
                JOIN clientes c ON v.cliente_id = c.id
                GROUP BY c.id, c.nombre
        ");
        $stmt->execute();
        $estado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Estado del Cliente segun menbresia:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre del Cliente</th>
        <th>Total</th>
        <th>Estado de Menbresia</th>
        </tr>";
        foreach($estado as $fila){
        echo "<tr>";
        echo "<td> " . $fila['nombre_cliente'] . "</td>";
        echo "<td> " . $fila['total'] . "</td>";
        echo "<td>" . $fila['estado'] . "</td>";
        echo "</tr>";
        }   
        echo "</table>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Probar los triggers
verificarCambiosPrecio($pdo, 1, 999.99);
verificarMovimientoInventario($pdo, 1, 15);
obtenerEstadisticasVentasPorCategoria($pdo);//las pruebas se hacen en mysql
obtenerAlertaStockCritico($pdo);//las pruebas se hacen en mysql
obtenerHistorialEstadoCliente($pdo);//las pruebas se hacen en mysql
obtenerTotalVentasPorCliente($pdo);//las pruebas se hacen en mysql

$pdo = null;
?>