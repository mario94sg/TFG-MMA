<?php
// Nueva contraseña
$nueva_contrasena = '123456';

// Generar el hash con bcrypt (por defecto)
$hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

// Mostrar el resultado
echo "El hash generado es:<br>";
echo "<pre>$hash</pre>";
?>