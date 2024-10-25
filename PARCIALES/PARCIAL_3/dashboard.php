<?
session_start();

if (isset($_SESSION['usuario'])) {
    $_SESSION['usuario'];
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $titulo =$_POST['titulo'];
    $fechaLimite=$_POST['fecha_limite'];

    if (!empty($titulo) || !empty($fechaLimite) || strtotime($fechaLimite)<=date()) {
        $error="la fecha debe ser mayor al dia de hoy";
    }else {
    $tareas[]=[
        'titulo'=>$titulo,
        'fecha_limite'=>$fechaLimite
    ];
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <H2>FORMULARIO PARCIAL 3</H2>
    <?php $error ?>    
    <form method="POST">
    <label for="titulo">Titulo</label><br>
    <input type="text" name="titulo" required><br>
    <label for="fecha_limite">Fecha Limite</label><br>
    <input type="date" name="fecha_limite" required>
    <br>
    <br>

    <button type="submit">Agregar Tarea</button><br>

    <H2>Lista de Tareas</H2>
    

    <a href="logout.php">Cerrar Sesion</a>
    </form>
</body>