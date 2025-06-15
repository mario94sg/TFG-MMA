<?php


$lat = '40.990431';
$lng = '-4.208429';
$zoom = 18;
$size = '600x300';
$scale = 2;
$icon = 'https://cdn-icons-png.flaticon.com/512/684/684908.png';

$key = 'AIzaSyBGEN1DLMdEnPnC5iwbhqEODeaijBRIgRU'; 

$mapUrl = "https://maps.googleapis.com/maps/api/staticmap?" . http_build_query([
    'center' => "$lat,$lng",
    'zoom' => $zoom,
    'size' => $size,
    'scale' => $scale,
    'markers' => "icon:$icon|$lat,$lng",
    'key' => $key
]);

// Redirige a la imagen del mapa
header("Location: $mapUrl");
exit;