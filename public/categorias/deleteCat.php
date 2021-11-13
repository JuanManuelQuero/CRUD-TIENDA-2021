<?php
session_start();
require dirname(__DIR__, 2)."/vendor/autoload.php";
use Tienda\Categorias;

//Comprobar si existe el id que le pasamos
if(!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

(new Categorias)->delete($_POST['id']);
$_SESSION['mensaje'] = "Categoría borrada correctamente";
header("Location:index.php");