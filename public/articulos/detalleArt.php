<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\Articulos;
use Tienda\Categorias;

$id = $_GET['id'];
$datosArticulo = (new Articulos)->read($id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Detalle Artículo</title>
</head>

<body>
    <h3 class="text-center mt-2">Detalle Artículo (<?php echo $datosArticulo->id; ?>)</h3>
    <div class="container mt-2">
        <div class="shadow-lg mx-auto bg-info text-white rounded-3 p-4" style="width:40rem">
            <h5 class="text-center"><?php echo $datosArticulo->nombre; ?></h5>
            <p class="mt-3">
                <b>Precio: </b>
                <?php echo $datosArticulo->precio ?>

            </p>
            <p class="mt-3">
                <b>Categoria: </b>
                <?php echo $datosArticulo->nombre . " (" . $datosArticulo->categoria_id . ")"; ?>
            </p>
            <div class="mt-2">
                <a href="index.php" class="btn btn-dark">
                    <i class="fas fa-backward"></i> Volver</a>
            </div>
            <div>

            </div>
</body>

</html>