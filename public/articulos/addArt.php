<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Tienda\Articulos;
use Tienda\Categorias;

$categorias = (new Categorias)->devolverCategorias();
//Creamos una función para comprobar si los campos están vacios
function campoVacio($n, $p)
{
    $error = false;
    if (strlen($n) == 0) {
        $_SESSION['vacio_nombre'] = "Rellene el campo nombre";
        $error = true;
    }

    if (strlen($p) == 0) {
        $_SESSION['vacio_precio'] = "Rellene el campo precio";
        $error = true;
    }
    return $error;
}

if (isset($_POST['Crear'])) {
    $nombre = trim(ucfirst($_POST['nombre']));
    $precio = trim($_POST['precio']);
    $categoria_id = $_POST['categoria_id'];
    if(!campoVacio($nombre, $precio)) {
        (new Articulos)->setNombre($nombre)
        ->setPrecio($precio)
        ->setCategoria_id($categoria_id)
        ->create();
        $_SESSION['mensaje'] = "Artículo creado correctamente";
        header("Location:index.php");
    } else {
        header("Location:{$_SERVER['PHP_SELF']}");
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Nuevo artículo</title>
</head>

<body>
    <h3 class="text-center mt-3">Nuevo Artículo</h3>
    <div class="container mt-4">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="a" method="POST">
            <div class="bg-info p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre Artículo</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" required>
                    <?php
                    if (isset($_SESSION['vacio_nombre'])) {
                        echo "<div class='text-danger mt-2'>{$_SESSION['vacio_nombre']}</div>";
                        unset($_SESSION['vacio_nombre']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="p" class="form-label">Precio Artículo</label>
                    <input type="text" class="form-control" id="p" name="precio" placeholder="Precio">
                    <?php
                    if (isset($_SESSION['vacio_precio'])) {
                        echo "<div class='text-danger mt-2'>{$_SESSION['vacio_precio']}</div>";
                        unset($_SESSION['vacio_precio']);
                    }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="cid" class="form-label">Categoría del Artículo</label>
                    <select name="categoria_id" id="cid" class="form-select">
                        <?php
                            foreach($categorias as $item) {
                                echo "<option value='{$item->id}'>{$item->nombre}</option>";
                            }
                        ?>  
                    </select>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="Crear"><i class="fas fa-check-circle"></i> Crear</button>
                    <button type="reset" class="btn btn-danger"><i class="fas fa-broom"></i> Limpiar</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
<?php } ?>