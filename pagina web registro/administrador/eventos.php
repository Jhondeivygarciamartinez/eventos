<?php 
session_start();


if (!isset($_SESSION['usuario'])) {
 
    header("Location: login.php");
    exit();
}

include('template/cabecera.php');
?>

<?php

$txtid = (isset($_POST['txtid'])) ? $_POST['txtid'] : "";
$txttitulo = (isset($_POST['txttitulo'])) ? $_POST['txttitulo'] : "";
$txtdescripcion = (isset($_POST['txtdescripcion'])) ? $_POST['txtdescripcion'] : "";
$txtfecha = (isset($_POST['txtfecha'])) ? date('Y-m-d', strtotime($_POST['txtfecha'])) : ""; 
$txtubicacion = (isset($_POST['txtubicacion'])) ? $_POST['txtubicacion'] : "";
$txtorganizador_id = (isset($_POST['txtorganizador_id'])) ? $_POST['txtorganizador_id'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

$host = "localhost";
$bd = "portal_eventos_comunitarios"; 
$usuario = "root";
$contrasena = "";

try {
    
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Error de conexión: " . $ex->getMessage();
}

switch ($accion) {
    case "Agregar":
        if ($conexion) {
         
            $verificarOrganizador = $conexion->prepare("SELECT id FROM usuarios WHERE id = :organizador_id");
            $verificarOrganizador->bindParam(':organizador_id', $txtorganizador_id);
            $verificarOrganizador->execute();

            if ($verificarOrganizador->rowCount() > 0) {
                $sentenciaSQL = $conexion->prepare("INSERT INTO eventos (titulo, descripcion, fecha, ubicacion, organizador_id) VALUES (:titulo, :descripcion, :fecha, :ubicacion, :organizador_id)");
                $sentenciaSQL->bindParam(':titulo', $txttitulo);
                $sentenciaSQL->bindParam(':descripcion', $txtdescripcion);
                $sentenciaSQL->bindParam(':fecha', $txtfecha);
                $sentenciaSQL->bindParam(':ubicacion', $txtubicacion);
                $sentenciaSQL->bindParam(':organizador_id', $txtorganizador_id);
                $sentenciaSQL->execute();
                echo "Evento agregado correctamente<br/>";
            } else {
                echo "Error: El organizador con ID $txtorganizador_id no existe en la tabla usuarios.<br/>";
            }
        }
        break;
        case "Modificar":
            if ($conexion) {
        
                $verificarEvento = $conexion->prepare("SELECT id FROM eventos WHERE fecha = :fecha");
                $verificarEvento->bindParam(':fecha', $txtfecha); // Cambié a :fecha
                $verificarEvento->execute();
        
          
                if ($verificarEvento->rowCount() > 0) {
                
                    $evento = $verificarEvento->fetch(PDO::FETCH_ASSOC);
                    $txtid = $evento['id']; 
        
                    $sentenciaSQL = $conexion->prepare("UPDATE eventos SET titulo=:titulo, descripcion=:descripcion, fecha=:fecha, ubicacion=:ubicacion, organizador_id=:organizador_id WHERE id=:id");
                    $sentenciaSQL->bindParam(':titulo', $txttitulo);
                    $sentenciaSQL->bindParam(':descripcion', $txtdescripcion);
                    $sentenciaSQL->bindParam(':fecha', $txtfecha);
                    $sentenciaSQL->bindParam(':ubicacion', $txtubicacion);
                    $sentenciaSQL->bindParam(':organizador_id', $txtorganizador_id);
                    $sentenciaSQL->bindParam(':id', $txtid);
        
                    try {
                        $sentenciaSQL->execute();
                        echo "Evento modificado correctamente<br/>";
                    } catch (PDOException $e) {
                        echo "Error al modificar el evento: " . $e->getMessage();
                    }
                } else {
                    echo "No se encontró ningún evento con la fecha especificada.<br/>";
                }
            }
            break;
    case "Borrar":
        if ($conexion) {
            $sentenciaSQL = $conexion->prepare("DELETE FROM eventos WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtid);
            $sentenciaSQL->execute();
            echo "Evento borrado correctamente<br/>";
        }
        break;
}


$sentenciaSQL = $conexion->prepare("SELECT * FROM eventos");
$sentenciaSQL->execute();
$listaEventos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-5">
          
            <div class="card">
                <div class="card-header">Datos del Evento</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="txttitulo">Título:</label>
                            <input type="text" class="form-control" name="txttitulo" id="txttitulo" value="<?php echo $txttitulo; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="txtdescripcion">Descripción:</label>
                            <textarea class="form-control" name="txtdescripcion" id="txtdescripcion" required><?php echo $txtdescripcion; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="txtfecha">Fecha:</label>
                            <input type="date" class="form-control" name="txtfecha" id="txtfecha" value="<?php echo $txtfecha; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="txtubicacion">Ubicación:</label>
                            <input type="text" class="form-control" name="txtubicacion" id="txtubicacion" value="<?php echo $txtubicacion; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="txtorganizador_id">Organizador ID:</label>
                            <input type="text" class="form-control" name="txtorganizador_id" id="txtorganizador_id" value="<?php echo $txtorganizador_id; ?>" required>
                        </div>
                        <div class="btn-group">
                            <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Organizador ID</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaEventos as $evento) { ?>
                        <tr>
                            <td><?php echo $evento['id']; ?></td>
                            <td><?php echo $evento['titulo']; ?></td>
                            <td><?php echo $evento['descripcion']; ?></td>
                            <td><?php echo $evento['fecha']; ?></td>
                            <td><?php echo $evento['ubicacion']; ?></td>
                            <td><?php echo $evento['organizador_id']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="txtid" value="<?php echo $evento['id']; ?>">
                                    <input type="hidden" name="txttitulo" value="<?php echo $evento['titulo']; ?>">
                                    <input type="hidden" name="txtdescripcion" value="<?php echo $evento['descripcion']; ?>">
                                    <input type="hidden" name="txtfecha" value="<?php echo $evento['fecha']; ?>">
                                    <input type="hidden" name="txtubicacion" value="<?php echo $evento['ubicacion']; ?>">
                                    <input type="hidden" name="txtorganizador_id" value="<?php echo $evento['organizador_id']; ?>">
                                    <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="txtid" value="<?php echo $evento['id']; ?>">
                                    <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('template/pie.php'); ?>