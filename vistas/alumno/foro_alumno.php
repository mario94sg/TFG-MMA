<?php
$tipoEsperado = "alumno";
require_once "../../controlador/verificar_sesion.php";
include "../componentes/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Foro - Alumno</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../js/foro_alumno.js"></script>
  <link rel="stylesheet" href="../../css/foro_alumno.css">
</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Foro - Alumno <?= htmlspecialchars($_SESSION['nombre']) ?></h1>

    <nav class="mb-4 text-center">
      <a href="vista_alumno.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_alumno.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="calendario_alumno.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_alumno.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_alumno.php" class="btn btn-primary me-2">Foro</a>
      <a href="nutricion_alumno.php" class="btn btn-outline-primary">Nutrición</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar sesión</button>
    </nav>

    <div class="d-flex justify-content-between align-items-start mb-3">
      <div id="asuntos-container" class="d-flex flex-wrap gap-2"></div>
      <form id="form-nuevo-asunto" class="ms-3 w-25">
        <div class="mb-2">
          <input type="text" class="form-control" id="titulo_asunto" placeholder="Nuevo asunto" required />
        </div>
        <div>
          <textarea class="form-control" id="mensaje_inicial" rows="2" placeholder="Mensaje inicial..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success mt-2 w-100">Crear asunto</button>
      </form>
    </div>

    <div id="conversaciones" class="accordion"></div>
  </div>

  <!-- Modales -->
  <div class="modal fade" id="modalAlert" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Mensaje</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" id="modalAlertBody"></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar este mensaje?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>