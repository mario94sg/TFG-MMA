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
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Noticias - Entrenador <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_entrenador.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_entrenador.php" class="btn btn-primary me-2">Noticias</a>
      <a href="alumnos_entrenador.php" class="btn btn-outline-primary me-2">Alumnos</a>
      <a href="calendario_entrenador.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_entrenador.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_entrenador.php" class="btn btn-outline-primary">Foro</a>
      <a href="nutricion_entrenador.php" class="btn btn-outline-primary">Nutrición</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>

    <div class="card mb-4">
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

    <div id="listaNoticias" class="row row-cols-1 g-4">
    </div>
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
</body>

</html>