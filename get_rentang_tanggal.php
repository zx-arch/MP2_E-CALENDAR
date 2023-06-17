<?php // get_rentang_tanggal.php

require_once "App/backend/query.php";

$methodQuery = new MethodQuery();

$rentangTanggal = $methodQuery->getRentangTanggal($_SESSION['username']);

// Mengatur header untuk mengindikasikan bahwa respons adalah JSON
header('Content-Type: application/json');

// Mengembalikan data rentang tanggal dalam format JSON
echo json_encode($rentangTanggal);

?>