<?php

namespace App\Entity;

class ProdutoVenda
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
     * @var integer
     */
    private $id_produto;

    /**
     * @var string
     */
    private $lote;

    /**
     * @var int
     */
    private $quantidade;

    /**
     * @var float
     */
    private $preco_comp;

    /**
     * @var float
     */
    private $preco_ven;

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

    public function getIdProduto(): ?int
    {
        return $this->id_produto;
    }

    public function setIdProduto(int $id_produto): self
    {
        $this->id_produto = $id_produto;
        
        return $this;
    }

    public function getLote(): ?string
    {
        return $this->lote;
    }

    public function setLote(string $lote): self
    {
        $this->lote = $lote;

        return $this;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getPrecoComp(): ?float
    {
        return $this->preco_comp;
    }

    public function setPrecoComp(float $preco_comp): self
    {
        $this->preco_comp = $preco_comp;

        return $this;
    }

    public function getPrecoVenda(): ?float
    {
        return $this->preco_ven;
    }

    public function setPrecoVenda(float $preco_ven): self
    {
        $this->preco_ven = $preco_ven;

        return $this;
    }
}