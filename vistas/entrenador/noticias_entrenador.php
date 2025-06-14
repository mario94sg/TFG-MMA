<?php
$tipoEsperado = "entrenador";
require_once "../../controlador/verificar_sesion.php";
include "../componentes/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Noticias - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="../../js/noticias_entrenador.js"></script>
  <link rel="stylesheet" href="../../css/noticias_entrenador.css">
</head>

<body>
  <header class="header-container">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-center gap-3">
      <div class="logo-box">
        <img src="../../media/images/logo.jpeg" alt="logo" />
      </div>
      <h1 class="main-title text-center">TZINAVOS TEAM MMA <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    </div>
  </header>
  <div class="container mt-4">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark rounded px-3">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="noticias_entrenador.php">Noticias</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_entrenador.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="alumnos_entrenador.php" class="nav-link">Alumnos</a></li>
            <li class="nav-item"><a href="calendario_entrenador.php" class="nav-link">Calendario</a></li>
            <li class="nav-item"><a href="ejercicios_entrenador.php" class="nav-link">Ejercicios</a></li>
            <li class="nav-item"><a href="foro_entrenador.php" class="nav-link">Foro</a></li>
            <li class="nav-item"><a href="nutricion_entrenador.php" class="nav-link">Nutrición</a></li>
          </ul>
          <button class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Cerrar sesión
          </button>
        </div>
      </div>
    </nav>
  </div>
  <section class="info-section bg-light py-5">
    <div class="container mt-4">
      <div class="card mb-4" class="formulario-container">
        <div class="card-header bg-primary text-white">Publicar nueva noticia</div>
        <div class="card-body">
          <form id="formNoticia">
            <div class="mb-3">
              <label for="titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
              <label for="contenido" class="form-label">Contenido</label>
              <textarea class="form-control" id="contenido" name="contenido" rows="4" required></textarea>
            </div>
            <input type="hidden" name="accion" value="crear">
            <button type="submit" class="btn btn-success">Publicar</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <section class="info-section bg-light py-5">
    <div class="container mt-4">
      <h2 class="section-title">Últimas noticias</h2>
      <div id="listaNoticias" class="row row-cols-1 g-4"></div>
    </div>
  </section>

  <!-- Modales -->
  <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formEditarNoticia">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarLabel">Editar Noticia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="edit_id_noticia" name="id_noticia">
            <div class="mb-3">
              <label for="edit_titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="edit_titulo" name="titulo" required>
            </div>
            <div class="mb-3">
              <label for="edit_contenido" class="form-label">Contenido</label>
              <textarea class="form-control" id="edit_contenido" name="contenido" rows="4" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar esta noticia?
          <input type="hidden" id="delete_id_noticia">
        </div>
        <div class="modal-footer">
          <button id="confirmarEliminar" class="btn btn-danger">Eliminar</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- Footer -->
  <footer class="bg-dark text-white py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
      <img src="../../media/images/mirmidones.jpeg" alt="mirmidones" class="footer-img mb-3 mb-md-0">
      <div class="text-center mx-md-5">
        <h3 class="fw-bold">¡Contacta con el maestro!</h3>
        <p>Tlf: 652 91 31 27 </p>
        <p>Email maestro: tzinavosteam@hotmail.com</p>
        <p>Email para ayuda de la web: support@tzinavosteam.online</p>
      </div>
      <img src="../../media/images/pankrationw.jpeg" alt="pankration" class="footer-img mb-3 mb-md-0">
    </div>
  </footer>
</body>

</html>