<?php

namespace App\Entity;

class Categoria
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $id_usuario;

    /**
     * @var string
     */
    private $categoria;

    /**
     * @var string
     */
    private $descricao;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }
    
}
