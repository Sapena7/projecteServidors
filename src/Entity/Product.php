<?php

declare(strict_types=1);

namespace App\Entity;
use DateTime;

class Product{
    private $Id;
    private $Nombre;
    private $Descripcion;
    private $Precio;
    private $Marca;
    private $Img;
    private $Categoria;
    private $Stock;
    private $Fecha;
    private $Usuario;



    public function __construct(){
        settype($this->Id, 'integer');
    }

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->Id;
    }

    /**
     * @param mixed $id
     */
    public function setId(int $id)
    {
        $this->Id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre():string
    {
        return $this->Nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre(string $nombre)
    {
        $this->Nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getDescripcion():string
    {
        return $this->Descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion(string $descripcion)
    {
        $this->Descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getPrecio():float
    {
        if (is_string($this->Precio)){
            $this->Precio = floatval($this->Precio);
        }
        return $this->Precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio(float $precio)
    {
        $this->Precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getMarca():int
    {
        return $this->Marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca(int $marca)
    {
        $this->Marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getImg():string
    {
        return $this->Img;
    }

    /**
     * @param mixed $img
     */
    public function setImg(string $img)
    {
        $this->Img = $img;
    }

    /**
     * @return mixed
     */
    public function getCategoria():int
    {
        return $this->Categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria(int $categoria)
    {
        $this->Categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getStock():string
    {
        return $this->Stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock(string $stock)
    {
        $this->Stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getFecha(): \DateTime
    {
        if (is_string($this->Fecha))
            $this->Fecha = new \DateTime($this->Fecha);

        return $this->Fecha;
    }

    /**
     * @param mixed $Fecha
     */
    public function setFecha(\DateTime $Fecha) :void
    {
        $this->Fecha = $Fecha;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->Usuario;
    }

    /**
     * @param mixed $Usuario
     */
    public function setUsuario($Usuario)
    {
        $this->Usuario = $Usuario;
    }

}