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
    private $idImagem;

    /**
     * @var integer
     */
    private $idUsuario;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdImagem(): ?int
    {
        return $this->idImagem;
    }

    public function setIdImagem(int $idImagem): self
    {
        $this->idImagem = $idImagem;
        
        return $this;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): self
    {
        $this->idUsuario = $idUsuario;
        
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