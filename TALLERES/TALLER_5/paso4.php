<?php
// Paso 4: Ordenamiento y Filtrado Avanzado de Arreglos

// 1. Definir el arreglo de libros
$biblioteca = [
    [
        "titulo" => "Cien años de soledad",
        "autor" => "Gabriel García Márquez",
        "año" => 1967,
        "genero" => "Realismo mágico",
        "prestado" => true
    ],
    [
        "titulo" => "1984",
        "autor" => "George Orwell",
        "año" => 1949,
        "genero" => "Ciencia ficción",
        "prestado" => false
    ],
    [
        "titulo" => "El principito",
        "autor" => "Antoine de Saint-Exupéry",
        "año" => 1943,
        "genero" => "Literatura infantil",
        "prestado" => true
    ],
    [
        "titulo" => "Don Quijote de la Mancha",
        "autor" => "Miguel de Cervantes",
        "año" => 1605,
        "genero" => "Novela",
        "prestado" => false
    ],
    [
        "titulo" => "Orgullo y prejuicio",
        "autor" => "Jane Austen",
        "año" => 1813,
        "genero" => "Novela romántica",
        "prestado" => true
    ]
];

// 2. Función para imprimir la biblioteca
function imprimirBiblioteca($libros) {
    foreach ($libros as $libro) {
        echo"<br>";
        echo "{$libro['titulo']} - {$libro['autor']} ({$libro['año']}) - {$libro['genero']} - " . 
             ($libro['prestado'] ? "Prestado" : "Disponible") . "\n";
             
    }
    echo "\n";
}

echo "Biblioteca original:\n";
imprimirBiblioteca($biblioteca);
echo"<br>";

// 3. Ordenar libros por año de publicación (del más antiguo al más reciente)
usort($biblioteca, function($a, $b) {
    return $a['año'] - $b['año'];
});
echo"<br>";
echo "Libros ordenados por año de publicación:\n";
imprimirBiblioteca($biblioteca);
echo"<br>";
// 4. Ordenar libros alfabéticamente por título
usort($biblioteca, function($a, $b) {
    return strcmp($a['titulo'], $b['titulo']);
});
echo"<br>";
echo "Libros ordenados alfabéticamente por título:\n";
imprimirBiblioteca($biblioteca);
echo"<br>";
// 5. Filtrar libros disponibles (no prestados)
$librosDisponibles = array_filter($biblioteca, function($libro) {
    return !$libro['prestado'];
});
echo"<br>";
echo "Libros disponibles:\n";
imprimirBiblioteca($librosDisponibles);
echo"<br>";
// 6. Filtrar libros por género
function filtrarPorGenero($libros, $genero) {
    return array_filter($libros, function($libro) use ($genero) {
        return strcasecmp($libro['genero'], $genero) === 0;
    });
}

$librosCienciaFiccion = filtrarPorGenero($biblioteca, "Ciencia ficción");
echo"<br>";
echo "Libros de Ciencia ficción:\n";
imprimirBiblioteca($librosCienciaFiccion);
echo"<br>";
// 7. Obtener lista de autores únicos
$autores = array_unique(array_column($biblioteca, 'autor'));
sort($autores);
echo"<br>";
echo "Lista de autores:\n";
foreach ($autores as $autor) {
    echo "- $autor\n";
}
echo "\n";
echo"<br>";

// 8. Calcular el año promedio de publicación
$añoPromedio = array_sum(array_column($biblioteca, 'año')) / count($biblioteca);
echo "Año promedio de publicación: " . round($añoPromedio, 2) . "\n\n";

// 9. Encontrar el libro más antiguo y el más reciente
$libroMasAntiguo = array_reduce($biblioteca, function($carry, $libro) {
    return (!$carry || $libro['año'] < $carry['año']) ? $libro : $carry;
});

$libroMasReciente = array_reduce($biblioteca, function($carry, $libro) {
    return (!$carry || $libro['año'] > $carry['año']) ? $libro : $carry;
});

echo "Libro más antiguo: {$libroMasAntiguo['titulo']} ({$libroMasAntiguo['año']})\n";
echo "Libro más reciente: {$libroMasReciente['titulo']} ({$libroMasReciente['año']})\n\n";

// 10. TAREA: Implementa una función de búsqueda que permita buscar libros por título o autor
// La función debe ser capaz de manejar búsquedas parciales y no debe ser sensible a mayúsculas/minúsculas
function buscarLibros($biblioteca, $termino) {
    // Tu código aquí
    return array_filter($biblioteca, function($libro) use ($termino) {
        $termino = strtolower($termino);
        return strpos(strtolower($libro['titulo']), $termino) !== false || strpos(strtolower($libro['autor']), $termino) !== false;
    });
}
echo"<br>";
echo"<br>";
// Ejemplo de uso de la función de búsqueda (descomenta para probar)
$resultadosBusqueda = buscarLibros($biblioteca, "quijote");
echo "Resultados de búsqueda para 'quijote':\n";
imprimirBiblioteca($resultadosBusqueda);

// 11. TAREA: Crea una función que genere un reporte de la biblioteca
// El reporte debe incluir: número total de libros, número de libros prestados,
// número de libros por género, y el autor con más libros en la biblioteca
function generarReporteBiblioteca($biblioteca) {
    // Tu código aquí
    $totalLibros = count($biblioteca);
    $librosPrestados = count(array_filter($biblioteca, function($libro) {
        return $libro['prestado'];
    }));
     // Contar el número de libros por género
     $librosPorGenero = [];
     foreach ($biblioteca as $libro) {
         $genero = $libro['genero'];
         if (!isset($librosPorGenero[$genero])) {
             $librosPorGenero[$genero] = 0;
         }
         $librosPorGenero[$genero]++;
     }
     
     // Contar el número de libros por autor
     $librosPorAutor = array_count_values(array_column($biblioteca, 'autor'));
     
     // Encontrar el autor con más libros
     $autorMasLibros = array_reduce(array_keys($librosPorAutor), function($carry, $autor) use ($librosPorAutor) {
         return ($librosPorAutor[$autor] > ($librosPorAutor[$carry] ?? 0)) ? $autor : $carry;
     });
     
     // Crear el reporte
     return [
         "total_libros" => $totalLibros,
         "libros_prestados" => $librosPrestados,
         "libros_por_genero" => $librosPorGenero,
         "autor_mas_libros" => $autorMasLibros,
         "cantidad_libros_autor" => $librosPorAutor[$autorMasLibros]
     ];
}
echo"<br>";
echo"<br>";
// Ejemplo de uso de la función de reporte (descomenta para probar)
echo "Reporte de la Biblioteca:\n";
echo"<br>";
print_r(generarReporteBiblioteca($biblioteca));

?>