<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';

$empresa = new Empresa();

// Crear algunos empleados
$gerente = new Gerente("Ana Pérez", 1, 5000, "Ventas");
$gerente->asignarBono(1000);  // Bono para el gerente

$desarrollador = new Desarrollador("Luis Gómez", 2, 4000, "PHP", "Senior");

// Agregar empleados a la empresa
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar empleados
echo "Lista de empleados:<br>";
$empresa->listarEmpleados();

echo "<br>Nómina total: {$empresa->calcularNominaTotal()} <br>";

// Realizar evaluaciones de desempeño
echo "<br>Evaluaciones de desempeño:<br>";
$empresa->realizarEvaluaciones();
?>
