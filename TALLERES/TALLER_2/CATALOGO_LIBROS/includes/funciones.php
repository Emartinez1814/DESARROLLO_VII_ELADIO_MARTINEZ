<?php
// Arreglo
$titulos = [
    ['titulo' => 'El Quijote',
    'autor' => 'Miguel de Cervantes',
    'publicacion' => 1605,
    'genero' => 'Novela',
    'descripcion' => 'La historia de Don Quijote de la Mancha.'
    ],
    ['titulo' => '1984',
    'autor' => 'George Orwell',
    'publicacion' => 1949,
    'genero' => 'Ciencia ficción',
    'descripcion' => 'Ambientada en un futuro totalitario donde el Gran Hermano vigila cada movimiento.'
    ],
    ["titulo" => "Matar a un ruiseñor",
        "autor" => "Harper Lee",
        "publicacion" => 1960,
        "genero" => "Ficción, Drama",
        "descripcion" => "Ambientada en el sur de Estados Unidos durante la Gran Depresión."
    ],
    ["titulo" => "El gran Gatsby",
        "autor" => "F. Scott Fitzgerald",
        "publicacion" => 1925,
        "genero" => "Ficción, Novela moderna",
        "descripcion" => "Situada en la década de 1920, esta novela sigue a Jay Gatsby y su obsesión por Daisy."
    ],
    ["titulo" => "Orgullo y prejuicio",
        "autor" => "Jane Austen",
        "publicacion" => 1813,
        "genero" => "Novela romántica",
        "descripcion" => "Esta obra clásica explora la vida y relaciones de Elizabeth Bennet."
    ],
];

//funcion para obtener y listar los libros
function obtenerLibros($titulos) {
    
//return $titulos['titulo'];
echo"<ul>";
foreach ($titulos as $titulo) {
    echo "<li>".$titulo['titulo'] ."</li>";
}
echo"</ul>";
//return $titulos;
}

// Función para brindar los detalles de los libros
function mostrarDetallesLibro($titulos) {
    //$titulos=obtenerLibros();

    foreach ($titulos as $titulo) {
        echo "<h3>" . $titulo['titulo'] . "</h3>";
        echo "<p><strong>Autor:</strong> " . $titulo['autor'] . "</p>";
        echo "<p><strong>Publicación:</strong> " . $titulo['publicacion'] . "</p>";
        echo "<p><strong>Género:</strong> " . $titulo['genero'] . "</p>";
        echo "<p><strong>Descripción:</strong> " . $titulo['descripcion'] . "</p>";
    }
}

?>
            
