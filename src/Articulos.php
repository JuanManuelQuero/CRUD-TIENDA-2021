<?php

namespace Tienda;

use Faker;
use PDO;
use PDOException;
use Tienda\Categorias;

class Articulos extends Conexion
{
    private $id;
    private $nombre;
    private $precio;
    private $categoria_id;

    //Creamos el constructor que heredara de la clase padre
    public function __construct()
    {
        parent::__construct();
    }

    //### CRUD ###
    public function create()
    {
        $q = "insert into articulos(nombre, precio, categoria_id) values(:n, :p, :ci)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p' => $this->precio,
                ':ci' => $this->categoria_id
            ]);
        } catch (PDOException $ex) {
            die("Error al crear el artículo: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos
        parent::$conexion = null;
    }

    public function read($id)
    {
        $q = "select articulos.*, articulos.nombre, descripcion from articulos, categorias where
        categoria_id=categorias.id AND articulos.id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al devolver los datos del artículo: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos los datos del articulo
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id)
    {
        $q = "update articulos set nombre=:n, precio=:p, categoria_id=:cid where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':cid'=>$this->categoria_id,
                ':i'=>$id
            ]);
        }catch(PDOException $ex) {
            die("Error al actualizar el artículo: ".$ex->getMessage());
        }
        //Cerramos la conexion a la base de datos
        parent::$conexion = null;
    }

    public function delete($id)
    {
        $q = "delete from articulos where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el artículo: " . $ex->getMessage());
        }
    }


    //### OTROS MÉTODOS ###
    public function hayArticulos()
    {
        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si ya hay articulos: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos el total de articulos
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public function generarArticulos($cantidad)
    {
        if ($this->hayArticulos() == 0) {
            $faker = Faker\Factory::create('es_ES');
            $categorias = (new Categorias)->devolverIdCategorias();
            for ($i = 0; $i < $cantidad; $i++) {
                $nombre = $faker->word();
                $precio = $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL);
                $categoria_id = $categorias[array_rand($categorias, 1)];
                (new Articulos)->setNombre($nombre)
                    ->setPrecio($precio)
                    ->setCategoria_id($categoria_id)
                    ->create();
            }
        }
    }

    public function readAll()
    {
        $q = "select * from articulos order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver los artículos: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos todos los datos
        parent::$conexion = null;
        return $stmt;
    }


    //### SETTERS AND GETTERS


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of categoria_id
     */
    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    /**
     * Set the value of categoria_id
     *
     * @return  self
     */
    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }
}
