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

try {
    $sql = "SELECT id_usuario, contrasena FROM usuarios WHERE email = ? AND tipo = 'alumno' AND registrado = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró una cuenta de alumno pendiente de registro con ese email.'
        ]);
        exit();
    }

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
        'redirect' => './vistas/actualizar_datos.php'
    ]);
    exit();
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
    exit();
}
