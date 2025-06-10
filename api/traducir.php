<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Método no permitido';
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$texto = $input['texto'] ?? '';

if (empty($texto)) {
    http_response_code(400);
    echo 'No se recibió texto para traducir';
    exit;
}

$apiUrl = 'https://translate.argosopentech.com/translate';

$data = [
    'q' => $texto,
    'source' => 'en',
    'target' => 'es',
    'format' => 'text',
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Error de conexión con la API']);
    curl_close($ch);
    exit;
}
curl_close($ch);
echo $response;
