<?php
class RecursoBiblioteca implements Prestable {
    public $id;
    public $titulo;
    public $autor;
    public $anioPublicacion;
    public $estado;
    public $fechaAdquisicion;
    public $tipo;

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}

// Implementar las clases Libro, Revista y DVD aquí

class Libro extends RecursoBiblioteca{
    public $isbn;

    public function __construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo,$isbn) {
        parent::__construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo);
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->estado = $estado;
        $this->fechaAdquisicion = $fechaAdquisicion;
        $this->tipo = $tipo;
        $this->isbn = $isbn;
    }

    public function obtenerDetallesPrestamo(){
        return $this->$id $this->$titulo $this->$autor $this->$anioPublicacion $this->$estado $this->$fechaAdquisicion $this->$tipo $this->$isbn ;
    }
}
class Revista extends RecursoBiblioteca{
    public $numeroEdicion;

    public function __construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo,$numeroEdicion) {
        parent::__construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo);
        
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->estado = $estado;
        $this->fechaAdquisicion = $fechaAdquisicion;
        $this->tipo = $tipo;
        $this->numeroEdicion = $numeroEdicion;
    }

    public function obtenerDetallesPrestamo(){
        return $this->$id $this->$titulo $this->$autor $this->$anioPublicacion $this->$estado $this->$fechaAdquisicion $this->$tipo $this->$numeroEdicion ;
    }
}
class DVD extends RecursoBiblioteca{
    public $duracion;

    public function __construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo,$duracion) {
        parent::__construct($id,$titulo,$autor,$anioPublicacion,$estado,$fechaAdquisicion,$tipo);
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
        $this->estado = $estado;
        $this->fechaAdquisicion = $fechaAdquisicion;
        $this->tipo = $tipo;
        $this->duracion = $duracion;
    }
    public function obtenerDetallesPrestamo(){
        return $this->$id $this->$titulo $this->$autor $this->$anioPublicacion $this->$estado $this->$fechaAdquisicion $this->$tipo $this->$duracion ;
    }
}
$estadosLegibles = [
    ["disponible" => "DISPONIBLE"],
    ["prestado" => "PRESTADO"],
    ["en_reparacion" => "EN REPARACIÓN"],
];

class GestorBiblioteca {
    private $recursos = [];

    public function cargarRecursos() {
        $json = file_get_contents('biblioteca.json');
        $data = json_decode($json, true);
        
        foreach ($data as $recursoData) {
            $recurso = new RecursoBiblioteca($recursoData);
            $this->recursos[] = $recurso;
        }

        switch ($recursoData['tipo']) {
            case 'disponible':
                $nuevaLibro = new  RecursoBiblioteca(
                    $recursoData['ID'],
                    $recursoData['autor'],
                    $recursoData['anioPublicacion'],
                    $recursoData['estado'],
                    $recursoData['fechaAdquisicion'],
                    $recursoData['tipo'],
                    $recursoData['isbn']
                );
                break;
            case 'prestado':
                $nuevaLibro = new  RecursoBiblioteca(
                    $recursoData['ID'],
                    $recursoData['autor'],
                    $recursoData['anioPublicacion'],
                    $recursoData['estado'],
                    $recursoData['fechaAdquisicion'],
                    $recursoData['tipo'],
                    $recursoData['isbn']
                );
                break;
            case 'en_reparacion':
                $nuevaLibro = new  RecursoBiblioteca(
                    $recursoData['ID'],
                    $recursoData['autor'],
                    $recursoData['anioPublicacion'],
                    $recursoData['estado'],
                    $recursoData['fechaAdquisicion'],
                    $recursoData['tipo'],
                    $recursoData['isbn']
                );
                break;
            default:
                throw new Exception("Tipo no existe");
        }
        
        return $this->recursos;
    }

    // Implementar los demás métodos aquí
    public function agregarRecurso(RecursoBiblioteca $recurso){
        $this->recursos[] = $recurso;
    }
    public function eliminarRecurso($id){
        foreach ($this->recursos as $id => $recurso) {
            if ($recurso->id === $id) {
                unset($this->recursos[$id]);
                return true;
            }
        }
        return false;
    }
    public function actualizarRecurso(RecursoBiblioteca $recurso){
        foreach ($this->recursos as &$recurso) {
            if ($recurso->id === $recursoActualizado->id) {
                $recurso = $recursoActualizado;
                return true;
            }
        }
        return false;
    }
    public function actualizarEstadoRecurso($id, $nuevoEstado){
        foreach ($this->recursos as &$recurso) {
            if ($recurso->id === $id) {
                $recurso->estado = $nuevoEstado;
                return true;
            }
        }
        return false;
    }
    public function buscarRecursosPorEstado($estado){
        $resultados = [];
        foreach ($this->recursos as $recurso) {
            if ($recurso->estado === $estado) {
                $resultados[] = $recurso;
            }
        }
        return $resultados;
    }
    public function listarRecursos($filtroEstado = '', $campoOrden = 'id', $direccionOrden = 'ASC'){
        $direccionOrden = 'ASC') {
            foreach ($this->recursos as $recurso) {
                if ($filtroEstado === '' || $recurso->estado === $filtroEstado) {
                    echo $recurso;
                }
            }
        }
    }
}