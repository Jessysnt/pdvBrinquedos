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
    private $idUsuario;

    /**
     * @var integer
     */
    private $idProduto;

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
    private $precoVenda;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdProduto(): ?int
    {
        return $this->idProduto;
    }

    public function setIdProduto(int $idProduto): self
    {
        $this->idProduto = $idProduto;
        
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

    public function getPrecoVenda(): ?float
    {
        return $this->precoVenda;
    }

    public function setPrecoVenda(float $precoVenda): self
    {
        $this->precoVenda = $precoVenda;

        return $this;
    }
}