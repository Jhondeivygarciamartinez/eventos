<?php
session_start();
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizadores y Eventos Disponibles</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #fa4417 ;
        }
        .container {
            margin-top: 40px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="/pagina%20web%20registro/administrador/inicio.php">Volver a Inicio</a>
</nav>

<div class="container">
    <h2 class="text-center">Organizadores y Eventos Disponibles</h2>

  
<div class="card mb-4">
    <div class="card-header">Buscar por organizador (ID o nombre):</div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="buscar">Buscar:</label>
                <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Escriba el ID o nombre del organizador">
            </div>
            <button type="submit" class="btn btn-primary" name="accion" value="Buscar">Buscar</button>
        </form>
    </div>
</div>


<h4 class="text-center">Organizadores</h4>
<div class="card mb-4">
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
               
                $host = "localhost";
                $bd = "portal_eventos_comunitarios"; 
                $usuario = "root";
                $contrasena = ""; 

                try {
                    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
                    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if (isset($_POST['accion']) && $_POST['accion'] == 'Buscar') {
                        $buscar = $_POST['buscar'];

                       
                        if (is_numeric($buscar)) {
                          
                            $sentenciaSQL = $conexion->prepare("
                                SELECT * 
                                FROM organizadores 
                                WHERE id = :buscar
                                ORDER BY created_at DESC
                            ");
                            $sentenciaSQL->bindParam(':buscar', $buscar);
                        } else {
                            
                            $sentenciaSQL = $conexion->prepare("
                                SELECT * 
                                FROM organizadores 
                                WHERE nombre_completo LIKE :buscar
                                ORDER BY created_at DESC
                            ");
                            $buscarTerm = "%" . $buscar . "%";
                            $sentenciaSQL->bindParam(':buscar', $buscarTerm);
                        }

                        $sentenciaSQL->execute();
                        $listaOrganizadores = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                        
                        if (!empty($listaOrganizadores)) {
                            foreach ($listaOrganizadores as $organizador) {
                                echo "<tr>";
                                echo "<td>" . $organizador['id'] . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['nombre_completo']) . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['correo']) . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['telefono']) . "</td>";
                                echo "<td>" . htmlspecialchars($organizador['created_at']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No se encontraron organizadores.</td></tr>";
                        }
                    }
                } catch (PDOException $ex) {
                    echo "Error de conexión: " . $ex->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
   
    <h4 class="text-center">Eventos Disponibles</h4>
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
                    try {
                        if (isset($_POST['accion']) && $_POST['accion'] == 'Buscar') {
                            $buscar = $_POST['buscar'];

                            
                            $sentenciaSQL = $conexion->prepare("
                                SELECT * 
                                FROM eventos 
                                WHERE titulo LIKE :buscar 
                                ORDER BY created_at DESC
                            ");
                            $buscarTerm = "%" . $buscar . "%";
                            $sentenciaSQL->bindParam(':buscar', $buscarTerm);
                            $sentenciaSQL->execute();
                            $listaEventos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

                     
                            if (!empty($listaEventos)) {
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
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No se encontraron eventos.</td></tr>";
                            }
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
<br/><br/>
<footer class="bg-light text-center py-4">
    <p>&copy; 2024 Portal de Eventos Comunitarios. Todos los derechos reservados.</p>
</footer>

</body>
</html>