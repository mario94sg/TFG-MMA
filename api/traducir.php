<?php
header('Content-Type: application/json');

if (!isset($_POST['texto'])) {
    echo json_encode(['error' => 'No se recibió texto para traducir.']);
    exit;
}

$texto = $_POST['texto'];
$from = 'en';
$to = 'es';

function traducirLingva($texto, $from = 'en', $to = 'es')
{
    //  se usa rawurlencode para evitar problemas con espacios
    $url = "https://lingva.ml/api/v1/$from/$to/" . rawurlencode($texto);

    $response = file_get_contents($url);
    if ($response === FALSE) {
        return '[Error en traducción]';
    }

    $data = json_decode($response, true);
    return $data['translation'] ?? '[Sin resultado]';
}

$traduccion = traducirLingva($texto, $from, $to);

echo json_encode(['traduccion' => $traduccion]);
