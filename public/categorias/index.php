<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\Categorias;

(new Categorias)->generarCategorias(10);
$datos = (new Categorias)->readAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Categorías</title>
</head>

<body>
    <h3 class="text-center mt-3">Categorías</h3>
    <div class="container mt-4">
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo <<<TXT
                <div class="alert alert-primary" role="alert">
                    {$_SESSION['mensaje']}
                </div>
            TXT;
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="addCat.php" class="btn btn-success"><i class="fas fa-plus-circle"></i> Nueva categoría</a>
        <a href="../index.php" class="btn btn-dark"><i class="fas fa-home"></i> Menú</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datos->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
                    <tr>
                        <th scope="row">{$fila->id}</th>
                        <td>{$fila->nombre}</td>
                        <td>{$fila->descripcion}</td>
                        <td>
                            <form name='a' action='deleteCat.php' method='POST'>
                                <input type='hidden' name='id' value='{$fila->id}'>
                                <a href='updateCat.php?id={$fila->id}' class='btn btn-primary'><i class='fas fa-edit'></i> Editar</a>
                                <button type='submit' class='btn btn-danger' onclick='return confirm("¿Desea borrar la categoría?")'><i class='fas fa-trash'></i> Borrar </button>
                            </form>
                        </td>
                    </tr>
                    TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>