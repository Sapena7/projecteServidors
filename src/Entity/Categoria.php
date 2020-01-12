<?php

declare(strict_types=1);

namespace App\Entity;

class Categoria{
    private $id;
    private $nombre;

    public function __construct(int $id, string $nombre){
        $this->id = $id;
        $this->nombre = $nombre;
    }

    /**
     * @return int
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id){
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string{
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }


}