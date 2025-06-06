<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Claves de la API 
$appId = '5ca39baf';
$appKey = 'bb8305866e8427a6f83cd52fc31074a5';
$userID = 'mario94sg';

// Obtener parámetros GET con valores por defecto
$query = trim($_GET['q'] ?? '');
$exclude = trim($_GET['exclude'] ?? '');
$diet = $_GET['diet'] ?? '';
$health = $_GET['health'] ?? '';
$mealType = $_GET['mealType'] ?? '';
$minCalories = intval($_GET['minCalories'] ?? 0);
$maxCalories = intval($_GET['maxCalories'] ?? 9999);
$maxPerServing = intval($_GET['maxPerServing'] ?? 9999);
$maxTime = intval($_GET['maxTime'] ?? 0);
$sort = $_GET['sort'] ?? '';

// Validación mínima
if (empty($query)) {
    echo json_encode(['error' => 'Debes ingresar un término de búsqueda']);
    exit;
}

// Construir el rango de calorías para la API
$caloriesRange = urlencode("$minCalories-$maxCalories");

// Construir la URL de la API de Edamam
$url = "https://api.edamam.com/api/recipes/v2?type=public"
     . "&q=" . urlencode($query)
     . "&app_id=$appId"
     . "&app_key=$appKey"
     . ($health ? "&health=" . urlencode($health) : "")
     . ($diet ? "&diet=" . urlencode($diet) : "")
     . ($mealType ? "&mealType=" . urlencode($mealType) : "")
     . ($exclude ? "&excluded=" . urlencode($exclude) : "")
     . "&calories=$caloriesRange"
     . ($maxTime > 0 ? "&time=1-" . $maxTime : "");

// Configurar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Edamam-Account-User: $userID"
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error de conexión: ' . curl_error($ch)]);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    echo json_encode(['error' => "Error HTTP $httpCode", 'respuesta' => $response]);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

// Filtrar recetas por calorías por porción
$filteredHits = [];
if (isset($data['hits'])) {
    foreach ($data['hits'] as $hit) {
        $receta = $hit['recipe'];
        $totalCalories = $receta['calories'];
        $yield = max(1, $receta['yield']);
        $caloriesPerServing = $totalCalories / $yield;

        if ($totalCalories <= $maxCalories && $caloriesPerServing <= $maxPerServing) {
            $filteredHits[] = $hit;
        }
    }
}

// Ordenar si se indicó
if ($sort === 'asc') {
    usort($filteredHits, fn($a, $b) => $a['recipe']['calories'] <=> $b['recipe']['calories']);
} elseif ($sort === 'desc') {
    usort($filteredHits, fn($a, $b) => $b['recipe']['calories'] <=> $a['recipe']['calories']);
}

// Enviar resultado final
header('Content-Type: application/json');
echo json_encode($filteredHits);
