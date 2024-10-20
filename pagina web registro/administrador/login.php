<?php
session_start();

if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contraseña'];

    $host = "localhost";
    $bd = "portal_eventos_comunitarios";
    $usuario_bd = "root";
    $contrasena_bd = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario_bd, $contrasena_bd);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $sentenciaSQL = $conexion->prepare("SELECT * FROM admins WHERE usuario = :usuario");
        $sentenciaSQL->bindParam(':usuario', $usuario);
        $sentenciaSQL->execute();
        $usuario_encontrado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

     
        if ($usuario_encontrado && $contrasena === $usuario_encontrado['contrasena']) {
         
            $_SESSION['usuario'] = $usuario;

          
            header("Location: eventos.php"); 
            exit();
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    } catch (PDOException $ex) {
        echo "Error de conexión: " . $ex->getMessage();
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: red; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <br><br><br><br><br><br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label>Usuario:</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña:</label>
                                <input type="password" class="form-control" name="contraseña" placeholder="Escribe tu contraseña" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </form>
                        <br>
                        <div>
                            <a href="inicio.php" class="btn btn-secondary">Acceder sin sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>