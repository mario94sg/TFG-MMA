<?php
session_start();
header('Content-Type: application/json');

if (!isset($_POST['codigo'])) {
    echo json_encode(['validado' => false, 'mensaje' => 'Código no recibido.']);
    exit;
}

$codigo_ingresado = trim($_POST['codigo']);

// Verificar si la cookie existe
if (!isset($_COOKIE['codigo_2fa'])) {
    echo json_encode(['validado' => false, 'mensaje' => 'No hay código activo.']);
    exit;
}

list($codigo_guardado, $expira) = explode('|', $_COOKIE['codigo_2fa']);

// Validar expiración
if (time() > intval($expira)) {

    setcookie('codigo_2fa', '', time() - 3600, '/');
    echo json_encode(['validado' => false, 'mensaje' => 'El código ha expirado.']);
    exit;
}


if ($codigo_ingresado === $codigo_guardado) {

    setcookie('codigo_2fa', '', time() - 3600, '/');


    echo json_encode([
        'validado' => true,
        'tipo' => $_SESSION['tipo'] ?? 'desconocido'
    ]);
    exit;
} else {
    echo json_encode(['validado' => false, 'mensaje' => 'Código incorrecto.']);
    exit;
}
