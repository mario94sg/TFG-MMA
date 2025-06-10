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
  <title>Nutricion - Entrenador</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../../js/nutricion_entrenador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../css/nutricion.css">
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
        <a class="navbar-brand fw-bold" href="nutricion_entrenador.php">Nutrición</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEntrenador" aria-controls="navbarEntrenador" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center" id="navbarEntrenador">
          <ul class="navbar-nav">
            <li class="nav-item"><a href="vista_entrenador.php" class="nav-link">Inicio</a></li>
            <li class="nav-item"><a href="alumnos_entrenador.php" class="nav-link">Alumnos</a></li>
            <li class="nav-item"><a href="noticias_entrenador.php" class="nav-link">Noticias</a></li>
            <li class="nav-item"><a href="calendario_entrenador.php" class="nav-link">Calendario</a></li>
            <li class="nav-item"><a href="ejercicios_entrenador.php" class="nav-link">Ejercicios</a></li>
            <li class="nav-item"><a href="foro_entrenador.php" class="nav-link">Foro</a></li>
          </ul>
          <button class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#logoutModal">
            Cerrar sesión
          </button>
        </div>
      </div>
    </nav>
  </div>
  <section class="info-section bg-light py-5">
    <div class="container mt-4 formulario-container">
      <h2 class="section-title">Buscar recetas</h2>
      <form id="formBusqueda" class="row g-3">
        <div class="col-md-3">
          <label for="query" class="form-label">Buscar por nombre</label>
          <input type="text" class="form-control" id="query" placeholder="Ej: pollo" required>
        </div>
        <div class="col-md-3">
          <label for="exclude" class="form-label">Excluir ingredientes</label>
          <input type="text" class="form-control" id="exclude" placeholder="Ej: nueces">
        </div>
        <div class="col-md-3">
          <label for="diet" class="form-label">Tipo de dieta</label>
          <select id="diet" class="form-select">
            <option value="">Sin preferencia</option>
            <option value="balanced">Balanceada</option>
            <option value="high-protein">Alta en proteína</option>
            <option value="low-fat">Baja en grasa</option>
            <option value="low-carb">Baja en carbohidratos</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="health" class="form-label">Restricción</label>
          <select id="health" class="form-select">
            <option value="">Sin restricción</option>
            <option value="vegetarian">Vegetariano</option>
            <option value="vegan">Vegano</option>
            <option value="gluten-free">Sin gluten</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="mealType" class="form-label">Tipo de comida</label>
          <select id="mealType" class="form-select">
            <option value="">Cualquiera</option>
            <option value="Breakfast">Desayuno</option>
            <option value="Lunch">Almuerzo</option>
            <option value="Dinner">Cena</option>
          </select>
        </div>
        <div class="col-md-3">
          <label for="maxCalories" class="form-label">Calorías máximas</label>
          <input type="number" class="form-control" id="maxCalories" placeholder="Ej: 2000" value="2000">
        </div>
        <div class="col-md-3">
          <label for="minCalories" class="form-label">Calorías mínimas</label>
          <input type="number" class="form-control" id="minCalories" placeholder="Ej: 200">
        </div>
        <div class="col-md-3">
          <label for="maxTime" class="form-label">Tiempo máx (min)</label>
          <input type="number" class="form-control" id="maxTime" placeholder="Ej: 30">
        </div>
        <div class="col-md-3">
          <label for="maxPerServing" class="form-label">Calorías máx por porción</label>
          <input type="number" class="form-control" id="maxPerServing" placeholder="Ej: 500" value="500">
        </div>
        <div class="col-md-3">
          <label for="sortOrder" class="form-label">Ordenar por</label>
          <select id="sortOrder" class="form-select">
            <option value="">Sin ordenar</option>
            <option value="asc">Calorías (asc)</option>
            <option value="desc">Calorías (desc)</option>
          </select>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-success w-100">Buscar recetas</button>
        </div>
      </form>
    </div>
  </section>
  <section class="info-section bg-light py-5">
      <h2 class="section-title">Recetas encontradas</h2>
      <div class="container mt-4" id="resultadosRecetas"></div>
  </section>
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