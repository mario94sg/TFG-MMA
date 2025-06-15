<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../../index.html");
    exit();
}

// Si se espera un tipo específico (alumno o entrenador)
if (isset($tipoEsperado) && $_SESSION['tipo'] !== $tipoEsperado) {
    echo "Acceso no autorizado para este tipo de usuario.";
    exit();
}
