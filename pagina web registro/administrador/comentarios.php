<?php
session_start(); 
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios y Valoraciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ff4d4d;
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
        <h2 class="text-center">Comentarios y Valoraciones</h2>

      
        <div class="card">
            <div class="card-header">Agregar Comentario</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nombre_completo">Nombre Completo:</label>
                        <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" required>
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea class="form-control" name="comentario" id="comentario" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="calificacion">Calificación (1 a 5):</label>
                        <input type="number" class="form-control" name="calificacion" id="calificacion" min="1" max="5" required>
                    </div>
                    <button type="submit" name="accion" value="Agregar" class="btn btn-primary">Agregar Comentario</button>
                </form>
            </div>
        </div>

      
        <h4 class="text-center">Comentarios Recientes</h4>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Comentario</th>
                            <th>Calificación</th>
                            <th>Fecha</th>
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
                                $comentario = $_POST['comentario'];
                                $calificacion = $_POST['calificacion'];

                                $sentenciaSQL = $conexion->prepare("INSERT INTO comentarios (nombre_completo, comentario, calificacion, created_at) VALUES (:nombre_completo, :comentario, :calificacion, NOW())");
                                $sentenciaSQL->bindParam(':nombre_completo', $nombre_completo);
                                $sentenciaSQL->bindParam(':comentario', $comentario);
                                $sentenciaSQL->bindParam(':calificacion', $calificacion);
                                $sentenciaSQL->execute();

                                echo "<div class='alert alert-success'>Comentario agregado correctamente</div>";
                            }

                       
                            $sentenciaSQL = $conexion->prepare("SELECT * FROM comentarios ORDER BY created_at DESC");
                            $sentenciaSQL->execute();
                            $listaComentarios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($listaComentarios as $comentario) {
                                echo "<tr>";
                                echo "<td>" . $comentario['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($comentario['nombre_completo']) . "</td>"; // Mostrar el nombre completo
                                echo "<td>" . htmlspecialchars($comentario['comentario']) . "</td>";
                                echo "<td>" . $comentario['calificacion'] . "</td>";
                                echo "<td>" . $comentario['created_at'] . "</td>";
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