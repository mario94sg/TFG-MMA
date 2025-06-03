<?php
require_once 'database.php';
session_start();


header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        'success' => false,
        'message' => 'Acceso no permitido.'
    ]);
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');

if (empty($nombre) || empty($email) || empty($contrasena)) {
    echo json_encode([
        'success' => false,
        'message' => 'Por favor, complete todos los campos.'
    ]);
    exit();
}


$sql = "SELECT id_usuario, contrasena FROM usuarios WHERE email = ? AND tipo = 'alumno' AND registrado = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    echo json_encode([
        'success' => false,
        'message' => 'No se encontró una cuenta de alumno pendiente de registro con ese email.'
    ]);
    exit();
}

$usuario = $resultado->fetch_assoc();


if (!password_verify($contrasena, $usuario['contrasena'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Contraseña incorrecta.'
    ]);
    exit();
}


$_SESSION['id_usuario'] = $usuario['id_usuario'];
$_SESSION['tipo'] = 'alumno';
$_SESSION['email'] = $email;

echo json_encode([
    'success' => true,
    'redirect' => './php/actualizar_datos.php'
]);
exit();
