<span class="navbar-text">
    <?php 
    if (isset($_SESSION['usuario'])) {
        echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario']);
    } else {
        echo ""; 
    }
    ?>
</span>
<!doctype html>
<html lang="en">
<head>
    <title>Portal de Eventos Comunitarios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        body {
            background-color: #f9f9fa;
        }
        .hero {
            background-image: url('/pagina%20web%20registro/img/5.jpeg'); 
            background-size: cover;
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .card {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Portal de Eventos</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/pagina%20web%20registro/administrador/reservaciones.php">Ver Reservaciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pagina%20web%20registro/administrador/comentarios.php">Comentarios y Valoraciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pagina%20web%20registro/administrador/buscar.php">Buscar Organizador o Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pagina%20web%20registro/administrador/contactos.php">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pagina%20web%20registro/administrador/login.php">Iniciar Seccion</a>
                </li>
            </ul>
        </div>
        <span class="navbar-text">
            <?php 
            if (isset($_SESSION['usuario'])) {
                echo "Bienvenido, " . htmlspecialchars($_SESSION['usuario']);
            } 
            ?>
        </span>
    </nav>

    <div class="hero">
        <h1>Eventos Comunitarios</h1>
        <p>¡Únete a nosotros en la celebración de nuestra comunidad!</p>
    </div>

    <div class="container">
        <h2 class="text-center my-4">Próximos Eventos</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="/pagina%20web%20registro/img/imagen1.jpeg" class="card-img-top" alt="Evento 1">
                    <div class="card-body">
                        <h5 class="card-title">Evento Deportivo</h5>
                        <p class="card-text">Un evento deportivo es una competición organizada donde atletas o equipos participan en diversas disciplinas deportivas. ¡No te lo pierdas!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="/pagina%20web%20registro/img/imagen2.jpeg" class="card-img-top" alt="Evento 2">
                    <div class="card-body">
                        <h5 class="card-title">Evento de Chefs</h5>
                        <p class="card-text">Un evento culinario donde chefs muestran sus habilidades en la cocina. ¡Participa con nosotros!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="/pagina%20web%20registro/img/imagen3.jpeg" class="card-img-top" alt="Evento 3">
                    <div class="card-body">
                        <h5 class="card-title">Evento para Bodas</h5>
                        <p class="card-text">Una celebración especial donde una pareja se une en matrimonio. ¡Te esperamos!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br/><br/><br/>
    <footer class="bg-light text-center py-4">
        <p>&copy; 2024 Portal de Eventos Comunitarios. Todos los derechos reservados.</p>
    </footer>

</body>
</html>