<?
session_start();

if(isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}

//array predefinido
$usuarios=[
    'Eladio'=>'12345',
    'Alberto'=>'6789'
];
//Validar las credenciales del usuario y manejo de sesiones
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $nombreUsuario=$_POST['nombre_usuario'];
    $contraseña=$_POST['contraseña'];

    if (isset($nombreUsuario) && isset($contraseña) && isset($nombreUsuario)=>$contraseña) {
        $_SESSION[$usuarios]=$nombreUsuario;
        header("Location: dashboard.php");
        exit();
    }else{
        $error = "Usuario o contraseña incorrectos";    
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcial</title>
</head>
<body>
    <H2>FORMULARIO PARCIAL 3</H2>
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <form method="POST">
    <label for="nombre_usuario">Usuario</label><br>
    <input type="text" name="nombre_usuario" required><br>
    <label for="contraseña">Contraseña</label><br>
    <input type="password" name="contraseña" required>
    <br>
    <br>

    <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>