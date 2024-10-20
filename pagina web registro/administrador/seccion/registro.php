<?php include("../template/cabecera.php"); ?>

<?php
$txtid = (isset($_POST['txtid'])) ? $_POST['txtid'] : "";
$txtnombre = (isset($_POST['txtnombre'])) ? $_POST['txtnombre'] : "";
$txtapellido = (isset($_POST['txtapellido'])) ? $_POST['txtapellido'] : "";
$txtemail = (isset($_POST['txtemail'])) ? $_POST['txtemail'] : "";
$txtcontrasena = (isset($_POST['txtcontrasena'])) ? $_POST['txtcontrasena'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


$host = "localhost";
$bd = "portal_eventos_comunitarios"; 
$usuario = "root";
$contrasena = ""; 

try {
     
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conectado a la base de datos<br/>";
} catch (PDOException $ex) {
    echo "Error de conexión: " . $ex->getMessage();
}

switch ($accion) {
    case "Agregar":
        if ($conexion) {
            $sentenciaSQL = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, email, contrasena) VALUES (:nombre, :apellido, :email, :contrasena)");
            $sentenciaSQL->bindParam(':nombre', $txtnombre);
            $sentenciaSQL->bindParam(':apellido', $txtapellido);
            $sentenciaSQL->bindParam(':email', $txtemail);
            $sentenciaSQL->bindParam(':contrasena', $txtcontrasena);
            $sentenciaSQL->execute();
            echo "Usuario agregado correctamente<br/>";
        }
        break;
    case "Modificar":
        if ($conexion) {
            $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, email=:email, contrasena=:contrasena WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtid);
            $sentenciaSQL->bindParam(':nombre', $txtnombre);
            $sentenciaSQL->bindParam(':apellido', $txtapellido);
            $sentenciaSQL->bindParam(':email', $txtemail);
            $sentenciaSQL->bindParam(':contrasena', $txtcontrasena);
            $sentenciaSQL->execute();
            echo "Usuario modificado correctamente<br/>";
        }
        break;
    case "Borrar":
        if ($conexion) {
            $sentenciaSQL = $conexion->prepare("DELETE FROM usuarios WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtid);
            $sentenciaSQL->execute();
            echo "Usuario borrado correctamente<br/>";
        }
        break;
}


$usuarios = $conexion->query("SELECT * FROM usuarios")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-5"> 
            <div class="card">
                <div class="card-header">
                    Datos de usuario
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="txtid">Id:</label>
                            <input type="text" class="form-control" name="txtid" id="txtid" placeholder="ID">
                        </div>
                        <div class="form-group">
                            <label for="txtnombre">Nombre:</label>
                            <input type="text" class="form-control" name="txtnombre" id="txtnombre" placeholder="Nombre del usuario">
                        </div>
                        <div class="form-group">
                            <label for="txtapellido">Apellido:</label>
                            <input type="text" class="form-control" name="txtapellido" id="txtapellido" placeholder="Apellido del usuario">
                        </div>
                        <div class="form-group">
                            <label for="txtemail">Email:</label>
                            <input type="text" class="form-control" name="txtemail" id="txtemail" placeholder="Email del usuario">
                        </div>
                        <div class="form-group">
                            <label for="txtcontrasena">Contraseña:</label>
                            <input type="text" class="form-control" name="txtcontrasena" id="txtcontrasena" placeholder="Contraseña del usuario">
                        </div>
                        <div class="btn-group" role="group" aria-label="">
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
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['contrasena']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="txtid" value="<?php echo $usuario['id']; ?>">
                                <input type="hidden" name="txtnombre" value="<?php echo $usuario['nombre']; ?>">
                                <input type="hidden" name="txtapellido" value="<?php echo $usuario['apellido']; ?>">
                                <input type="hidden" name="txtemail" value="<?php echo $usuario['email']; ?>">
                                <input type="hidden" name="txtcontrasena" value="<?php echo $usuario['contrasena']; ?>">
                                <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="txtid" value="<?php echo $usuario['id']; ?>">
                                <button type="submit" name="accion" value="Borrar" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../template/pie.php"); ?>