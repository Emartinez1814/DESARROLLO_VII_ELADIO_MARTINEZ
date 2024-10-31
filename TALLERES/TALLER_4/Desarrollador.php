<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {
    private $lenguajePrincipal;
    private $nivelExperiencia;

    public function __construct($nombre, $idEmpleado, $salarioBase, $lenguajePrincipal, $nivelExperiencia) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->nivelExperiencia = $nivelExperiencia;
    }

    public function getLenguajePrincipal() {
        return $this->lenguajePrincipal;
    }

    public function getNivelExperiencia() {
        return $this->nivelExperiencia;
    }

    public function evaluarDesempenio() {
        // Lógica personalizada para evaluar el desempeño del desarrollador
        return "Evaluación del desarrollador: Desempeño excelente en {$this->lenguajePrincipal}.";
    }

    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Lenguaje: {$this->lenguajePrincipal}, Nivel de experiencia: {$this->nivelExperiencia}";
    }
}
?>
