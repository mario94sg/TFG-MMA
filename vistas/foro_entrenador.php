<?php
$tipoEsperado = "entrenador";
require_once "../php/verificar_sesion.php";
include "../php/modal_logout.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Foro - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script>
    const userId = <?= json_encode($_SESSION['id_usuario']) ?>;
  </script>
  <script type="text/javascript" src="../js/foro_entrenador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../css/foro_entrenador.css">
</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Foro - Entrenador <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_entrenador.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_entrenador.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="alumnos_entrenador.php" class="btn btn-outline-primary me-2">Alumnos</a>
      <a href="calendario_entrenador.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_entrenador.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_entrenador.php" class="btn btn-primary me-2">Foro</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>

    <!-- Formulario para enviar mensajes -->
    <div class="card mb-4">
      <div class="card-header">Escribe un nuevo mensaje</div>
      <div class="card-body">
        <form id="form-mensaje">
          <div class="mb-3">
            <textarea class="form-control" id="mensaje" rows="3" required placeholder="Escribe tu mensaje aquí..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Publicar</button>
        </form>
      </div>
    </div>

    <div id="lista-mensajes"></div>
  </div>
  <!-- Modal de confirmación para eliminar mensaje -->
  <div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-danger">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="confirmarEliminarLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          ¿Estás seguro de que deseas eliminar este mensaje?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btn-confirmar-eliminar">Eliminar</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>