<?php

include_once 'interfaces.php';

//2.a. Clase abstracta Entrada que implemente la interfaz Detalle, con los siguientes
abstract class Entrada implements Detalle
{

    //2.a.1. id (entero)
    public int $id;
    //2.a.2. fecha_creacion (cadena en formato 'YYYY-MM-DD')
    public $fecha_creacion;
    //2.a.3. tipo (entero: 1, 2 o 3, representando el número de columnas)
    public int $tipo;

    public function __construct($datos = [])
    {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function obtenerDetallesEspecificos(): string
    {
        //return "ID: $this->id - Fecha de creación: $this->fecha_creacion - Tipo: $this->tipo";
        return 0;
    }
}

class GestorBlog
{
    private $entradas = [];

    //4.1. agregarEntrada(Entrada $entrada): Agrega una nueva entrada.
    public function agregarEntrada(Entrada $entrada): void
    {
        $this->entradas[] = $entrada;
    }

    //4.2. editarEntrada(Entrada $entrada): Actualiza una entrada existente.
    public function editarEntrada(Entrada $entrada): void
    {
        $id = $entrada->id;
        $this->entradas = array_map(function ($e) use ($entrada, $id) {
            if ($e->id == $id) {
                return $entrada;
            }
            return $e;
        }, $this->entradas);
    }

    //4.3. eliminarEntrada($id): Elimina una entrada por su ID.
    public function eliminarEntrada($id): void
    {
        $this->entradas = array_filter($this->entradas, function ($elemento) use ($id) {
            return $elemento->id != $id;
        });
    }

    //4.4. obtenerEntrada($id): Obtiene una entrada específica por su ID.
    public function obtenerEntrada($id): ?Entrada
    {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id == $id) {
                return $entrada;
            }
        }
        return null;
    }

    //4.5. moverEntrada($id, $direccion): Mueve una entrada hacia arriba o abajo en la lista.
    public function moverEntrada($id, $direccion): void
    {
        $index = null;
        foreach ($this->entradas as $i => $entrada) {
            if ($entrada->id == $id) {
                $index = $i;
                break;
            }
        }
        if ($index === null) {
            return;
        }
        $indexDestino = $direccion == 'arriba' ? $index - 1 : $index + 1;
        if ($indexDestino < 0 || $indexDestino >= count($this->entradas)) {
            return;
        }
        $temp = $this->entradas[$index];
        $this->entradas[$index] = $this->entradas[$indexDestino];
        $this->entradas[$indexDestino] = $temp;
    }

    public function cargarEntradas()
    {
        if (file_exists('blog.json')) {
            $json = file_get_contents('blog.json');
            $data = json_decode($json, true);
            foreach ($data as $entradaData) {
                if ($entradaData['tipo'] == 1) {
                    $this->entradas[] = new EntradaUnaColumna($entradaData);
                } elseif ($entradaData['tipo'] == 2) {
                    $this->entradas[] = new EntradaDosColumnas($entradaData);
                } elseif ($entradaData['tipo'] == 3) {
                    $this->entradas[] = new EntradaTresColumnas($entradaData);
                } else {
                    $this->entradas[] = new EntradaUnaColumna($entradaData);
                }

                //$this->entradas[] = new Entrada($entradaData);
            }
        }
    }

    public function guardarEntradas()
    {
        $data = array_map(function ($entrada) {
            return get_object_vars($entrada);
        }, $this->entradas);
        file_put_contents('blog.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    public function obtenerEntradas()
    {
        return $this->entradas;
    }
}

//2.b. Clase EntradaUnaColumna que herede de Entrada, con los atributos
//adicionales:
//2.b.1. titulo (cadena)
//2.b.2. descripcion (cadena)

class EntradaUnaColumna extends Entrada
{
    public string $titulo;
    public string $descripcion;

    //3.1. Para EntradaUnaColumna: Retornar "Entrada de una columna: [titulo]"
    public function obtenerDetallesEspecificos(): string
    {
        return "Entrada de una columna: $this->titulo";
    }
}

/*
2.c. Clase EntradaDosColumnas que herede de Entrada, con los atributos
adicionales:
1. titulo1 (cadena)
2. descripcion1 (cadena)
3. titulo2 (cadena)
4. descripcion2 (cadena)
*/

class EntradaDosColumnas extends Entrada
{
    public string $titulo1;
    public string $descripcion1;
    public string $titulo2;
    public string $descripcion2;

    //3.2. Para EntradaDosColumnas: Retornar "Entrada de dos columnas: [titulo1] | [titulo2]"
    public function obtenerDetallesEspecificos(): string
    {
        return "Entrada de dos columnas: $this->titulo1 | $this->titulo2";
    }
}

/*
2.d. Clase EntradaTresColumnas que herede de Entrada, con los atributos
adicionales:
1. titulo1 (cadena)
2. descripcion1 (cadena)
3. titulo2 (cadena)
4. descripcion2 (cadena)
5. titulo3 (cadena)
6. descripcion3 (cadena)
 */

class EntradaTresColumnas extends Entrada
{
    public string $titulo1;
    public string $descripcion1;
    public string $titulo2;
    public string $descripcion2;
    public string $titulo3;
    public string $descripcion3;

    //3. Para EntradaTresColumnas: Retornar "Entrada de tres columnas: [titulo1] | [titulo2] | [titulo3]"
    public function obtenerDetallesEspecificos(): string
    {
        return "Entrada de tres columnas: $this->titulo1 | $this->titulo2 | $this->titulo3";
    }
}
