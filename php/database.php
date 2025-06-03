<?php

$conn = mysqli_connect("213.165.71.189", "mario", "navalmanzano", "tzinavos");
if ($conn->connect_error) {
    die("Error de conexión a BD: " . $conn->connect_error);
}
