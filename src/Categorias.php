<?php

namespace Tienda;

use Faker;
use PDO;
use PDOException;
use PDORow;

class Categorias extends Conexion
{
    private $id;
    private $nombre;
    private $descripcion;

    //Creamos el constructor que heredara de la clase padre
    public function __construct()
    {
        parent::__construct();
    }

    //### CRUD ###
    public function create()
    {
        $q = "insert into categorias(nombre, descripcion) values(:n, :d)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion
            ]);
        } catch (PDOException $ex) {
            die("Error al crear la categoria: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos
        parent::$conexion = null;
    }

    public function read($id)
    {
        $q = "select * from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al devolver los datos de la categoría: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos los datos que queremos mostrar
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update()
    {
        $q = "update categorias set nombre=:n, descripcion=:d where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d' => $this->descripcion,
                ':i' => $this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar la categoría: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos
        parent::$conexion = null;
    }

    public function delete($id)
    {
        $q = "delete from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar la categoría: " . $ex->getMessage());
        }
        //Cerramos la conexion con la base de datos
        parent::$conexion = null;
    }

    //### OTROS MÉTODOS ###
    public function hayCategorias()
    {
        $q = "select * from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si ya hay categorias: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos el total de categorias
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public function generarCategorias($cantidad)
    {
        if ($this->hayCategorias() == 0) {
            $faker = Faker\Factory::create('es_ES');
            for ($i = 0; $i < $cantidad; $i++) {
                $nombre = $faker->word;
                $descripcion = $faker->text(50);
                (new Categorias)->setNombre($nombre)
                    ->setDescripcion($descripcion)
                    ->create();
            }
        }
    }

    public function readAll()
    {
        $q = "select * from categorias order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al mostrar los datos de las categorías: " . $ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos los datos que necesitamos
        parent::$conexion = null;
        return $stmt;
    }

    public function devolverIdCategorias()
    {
        $q = "select id from categorias order by id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver el id de categorias: " . $ex->getMessage());
        }
        //Creamos una array y guardamos en el los ids de las categorias
        $id = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $id[] = $fila->id;
        }
        //Cerramos la conexion a la base de datos y devolvermos el array que hemos creado
        parent::$conexion = null;
        return $id;
    }

    public function devolverCategorias() {
        $q = "select nombre, descripcion, id from categorias order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        }catch(PDOException $ex) {
            die("Error al devolver las categorías: ".$ex->getMessage());
        }
        //Cerramos la conexion a la base de datos y devolvemos los datos
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    //### GETTERS AND SETTER ###
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
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}
