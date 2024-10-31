<?php
//$Actual = 'titulo'; // Cambia esto según el archivo
require_once 'includes/funciones.php';
//$tituloPagina = mostrarDetallesLibro($libro);
include 'includes/header.php';

echo "<h2>Listado de Libros:</h2>";
//echo "<br>";
obtenerLibros($titulos);
//mostrarDetallesLibro();

echo "<h2>Detalle de Libros:</h2>";
mostrarDetallesLibro($titulos)
?>
<?php
include 'includes/footer.php';
?>