<?php
session_start(); 
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Organizador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fa4417;
        }
        .container {
            margin-top: 40px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="/pagina%20web%20registro/administrador/inicio.php">Inicio</a>
    </nav>

    <div class="container">
        <h2 class="text-center">Crear Organizador</h2>

       
        <div class="card">
            <div class="card-header">Agregar Organizador</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre_completo">Nombre Completo:</label>
                        <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo Electrónico:</label>
                        <input type="email" class="form-control" name="correo" id="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" name="telefono" id="telefono" required>
                    </div>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-primary">Agregar Organizador</button>
                </form>
            </div>
        </div>

   
        <h4 class="text-center">Organizadores Existentes</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Fecha de Creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $host = "localhost";
                        $bd = "portal_eventos_comunitarios"; 
                        $usuario = "root";
                        $contrasena = ""; 

                        try {
                            $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
                            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            
                            if (isset($_POST['accion']) && $_POST['accion'] == 'Agregar') {
                                $nombre_completo = $_POST['nombre_completo'];
                                $correo = $_POST['correo'];
                                $telefono = $_POST['telefono'];

                                $sentenciaSQL = $conexion->prepare("INSERT INTO organizadores (nombre_completo, correo, telefono, created_at) VALUES (:nombre_completo, :correo, :telefono, NOW())");
                                $sentenciaSQL->bindParam(':nombre_completo', $nombre_completo);
                                $sentenciaSQL->bindParam(':correo', $correo);
                                $sentenciaSQL->bindParam(':telefono', $telefono);
                                $sentenciaSQL->execute();

                                echo "<div class='alert alert-success'>Organizador agregado correctamente</div>";
                            }

                          
                            $sentenciaSQL = $conexion->prepare("SELECT * FROM organizadores ORDER BY created_at DESC");
                            $sentenciaSQL->execute();
                            $listaOrganizadores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($listaOrganizadores as $organizador) {
                                echo "<tr>";
                                echo "<td>" . $organizador['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['nombre_completo']) . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['correo']) . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['telefono']) . "</td>";
                                echo "<td>" . $organizador['created_at'] . "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $ex) {
                            echo "Error de conexión: " . $ex->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Portal de Eventos Comunitarios. Todos los derechos reservados.</p>
    </footer>

</body>
</html>