<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";
use Tienda\Categorias;

//Creamos una función para comprobar si los campos están vacios
function campoVacio($n, $d) {
    $error = false;
    if(strlen($n) == 0) {
        $_SESSION['vacio_nombre'] = "Rellene el campo nombre";
        $error = true;
    }

    if(strlen($d) == 0) {
        $_SESSION['vacio_descripcion'] = "Rellene el campo descripción";
        $error = true;
    }
    return $error;
}

//Creamos otra función para comprobar que el campo nombre tiene que tener al menos mas de 3 carácteres
function comprobarCampo($n, $d) {
    $error = false;
    if(strlen($n) < 3) {
        $_SESSION['corto_nombre'] = "El campo nombre tiene que tener al menos 3 carácteres";
        $error = true;
    }
    return $error;
}


if(isset($_POST['Crear'])) {
    $nombre = trim(ucfirst($_POST['nombre']));
    $descripcion = trim(ucfirst($_POST['descripcion']));
    if(!campoVacio($nombre, $descripcion) || !comprobarCampo($nombre, $descripcion)) {
        (new Categorias)->setNombre($nombre)
        ->setDescripcion($descripcion)
        ->create();
        $_SESSION['mensaje'] = "Categoría creada correctamente";
        header("Location:index.php");
        die();
    }
    header("Location:{$_SERVER['PHP_SELF']}");
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
    <title>Nuevo</title>
</head>

<body>
    <h3 class="text-center mt-3">Nueva Categoría</h3>
    <div class="container mt-4">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="a" method="POST">
            <div class="bg-info p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
                <div class="mb-3">
                    <label for="n" class="form-label">Nombre Categoría</label>
                    <input type="text" class="form-control" id="n" placeholder="Nombre" name="nombre" required>
                    <?php
                        if(isset($_SESSION['vacio_nombre'])) {
                            echo "<div class='text-danger mt-2'>{$_SESSION['vacio_nombre']}</div>";
                            unset($_SESSION['vacio_nombre']);
                        }
                        if(isset($_SESSION['corto_nombre'])) {
                            echo "<div class='text-danger mt-2'>{$_SESSION['corto_nombre']}</div>";
                            unset($_SESSION['corto_nombre']);
                        }
                    ?>
                </div>
                <div class="mb-3">
                    <label for="d" class="form-label">Descripción Categoría</label>
                    <input type="text" class="form-control" id="d" name="descripcion" placeholder="Descripción">
                    <?php
                        if(isset($_SESSION['vacio_descripcion'])) {
                            echo "<div class='text-danger mt-2'>{$_SESSION['vacio_descripcion']}</div>";
                            unset($_SESSION['vacio_descripcion']);
                        }
                    ?>
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