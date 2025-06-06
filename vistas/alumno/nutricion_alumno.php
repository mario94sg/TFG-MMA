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
  <title>Nutricion - Alumno</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../../js/nutricion_entrenador.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="../../css/nutricion_alumno.css">
</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Tzinavos Team MMA Nutrición- Alumno <?= htmlspecialchars($_SESSION['nombre']) ?></h1>
    <nav class="mb-4 text-center">
      <a href="vista_alumno.php" class="btn btn-outline-primary me-2">Inicio</a>
      <a href="noticias_alumno.php" class="btn btn-outline-primary me-2">Noticias</a>
      <a href="calendario_alumno.php" class="btn btn-outline-primary me-2">Calendario</a>
      <a href="ejercicios_alumno.php" class="btn btn-outline-primary me-2">Ejercicios</a>
      <a href="foro_alumno.php" class="btn btn-outline-primary">Foro</a>
      <a href="nutricion_alumno.php" class="btn btn-primary me-2">Nutrición</a>
      <button class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#logoutModal">
        Cerrar sesión
      </button>
    </nav>
    <div class="container mb-5">
      <h2 class="mb-3">Buscar recetas</h2>
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

    <div class="container" id="resultadosRecetas"></div>
  </div>

</body>

</html>