<?php
session_start();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones y Organizadores</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: red; 
        }
        .container {
            margin-top: 40px;
            background-color: white; 
            padding: 20px;
            border-radius: 5px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="/pagina%20web%20registro/administrador/inicio.php">Volver a Inicio</a>
</nav>

<div class="container">
    <h2 class="text-center">Listado de Reservaciones</h2>

  
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título del Evento</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Organizador ID</th>
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

                      
                        $sentenciaSQL = $conexion->prepare("SELECT * FROM eventos ORDER BY fecha ASC");
                        $sentenciaSQL->execute();
                        $listaEventos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listaEventos as $evento) {
                            echo "<tr>";
                            echo "<td>" . $evento['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($evento['titulo']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['descripcion']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['fecha']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['ubicacion']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['organizador_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($evento['created_at']) . "</td>";
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

   
    <h2 class="text-center">Listado de Organizadores</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Fecha de Creación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                  
                    try {
                        $sentenciaSQL = $conexion->prepare("SELECT * FROM organizadores ORDER BY created_at DESC");
                        $sentenciaSQL->execute();
                        $listaOrganizadores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($listaOrganizadores as $organizador) {
                            echo "<tr>";
                            echo "<td>" . $organizador['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($organizador['nombre_completo']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizador['correo']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizador['telefono']) . "</td>";
                            echo "<td>" . htmlspecialchars($organizador['created_at']) . "</td>";
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
<br/><br/><br/><br/>
<footer class="bg-light text-center py-4">
    <p>&copy; 2024 Portal de Eventos Comunitarios. Todos los derechos reservados.</p>
</footer>

</body>
</html>