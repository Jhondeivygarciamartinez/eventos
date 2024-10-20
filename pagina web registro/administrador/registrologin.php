<?php
if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contraseña']; 
    $tipo_usuario = $_POST['tipo_usuario'];

    
    $host = "localhost";
    $bd = "portal_eventos_comunitarios";
    $usuario_bd = "root";
    $contrasena_bd = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario_bd, $contrasena_bd);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $sentenciaSQL = $conexion->prepare("INSERT INTO admins (usuario, contrasena, tipo_usuario) VALUES (:usuario, :contrasena, :tipo_usuario)");
        $sentenciaSQL->bindParam(':usuario', $usuario);
        $sentenciaSQL->bindParam(':contrasena', $contrasena); // Guardar la contraseña tal cual fue ingresada
        $sentenciaSQL->bindParam(':tipo_usuario', $tipo_usuario);
        $sentenciaSQL->execute();

        echo "Usuario registrado correctamente";
    } catch (PDOException $ex) {
        echo "Error de conexión: " . $ex->getMessage();
    }
}
?>

<!doctype html>
<html lang="es">
<head>
    <title>Registro</title>
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
                        Registro de Usuario
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
                            <div class="form-group">
                                <label>Tipo de Usuario:</label>
                                <select class="form-control" name="tipo_usuario" required>
                                    <option value="administrador">Administrador</option>
                                    <option value="cliente">Cliente</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </form>
                        <br/>
                    
                        <a href="/pagina%20web%20registro/administrador/login.php" class="btn btn-secondary">Volver al Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>