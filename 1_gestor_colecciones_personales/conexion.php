<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "colecciones";

$connection = new mysqli($host, $user, $pass, $db);

if ($connection -> connect_error) {
    die ("Conexión fallida: " . $connection -> connect_error);
}