<?php
session_start();
require dirname(__DIR__, 2)."/vendor/autoload.php";
use Tienda\Articulos;

//Comprobar si existe el id que le pasamos
if(!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

(new Articulos)->delete($_POST['id']);
$_SESSION['mensaje'] = "Artículo borrado correctamente";
header("Location:index.php");