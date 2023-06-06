<?php

$host	= "localhost";
$user	= "root";
$pass	= "";
$db	= "mp2_calendar";

$mysqli = mysqli_connect($host, $user, $pass, $db);

if (!$mysqli) {
    die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
}