<?php

declare(strict_types=1);
namespace App\Entity;

class User{
    private $Id;
    private $Email;
    private $Nombre;
    private $Contrasena;
    private $Apellidos;
    private $Provincia;
    private $Img;
    private $Rol;

    public function __construct(){

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * @param mixed $Id
     */
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->Email = $email;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->Nombre;
    }

    /**
     * @param mixed $Nombre
     */
    public function setNombre($Nombre)
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return mixed
     */
    public function getContrasena()
    {
        return $this->Contrasena;
    }

    /**
     * @param mixed $Contrasena
     */
    public function setContrasena($Contrasena)
    {
        $this->Contrasena = $Contrasena;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->Img;
    }

    /**
     * @param mixed $Img
     */
    public function setImg($Img)
    {
        $this->Img = $Img;
    }

    /**
     * @return mixed
     */
    public function getApellidos()
    {
        return $this->Apellidos;
    }

    /**
     * @param mixed $Apellidos
     */
    public function setApellidos($Apellidos): void
    {
        $this->Apellidos = $Apellidos;
    }

    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->Provincia;
    }

    /**
     * @param mixed $Provincia
     */
    public function setProvincia($Provincia): void
    {
        $this->Provincia = $Provincia;
    }

    /**
     * @return mixed
     */
    public function getRol()
    {
        return $this->Rol;
    }

    /**
     * @param mixed $Rol
     */
    public function setRol($Rol)
    {
        $this->Rol = $Rol;
    }




}
