<?php

namespace App\Entity;

class Produto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var DateTime
     */
    private $registro;

    /**
     * @var integer
     */
    private $id_imagem;

    /**
     * @var integer
     */
    private $id_usuario;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdImagem(): ?int
    {
        return $this->id_imagem;
    }

    public function setIdImagem(int $id_imagem): self
    {
        $this->id_imagem = $id_imagem;
        
        return $this;
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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

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