<?php

namespace App\Entity;

class Estoque
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idProduto;

    /**
     * @var integer
     */
    private $quantotal;

    /**
     * @var float
     */
    private $precoVenda;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantotal(): ?int
    {
        return $this->quantotal;
    }

    public function setQuantotal(int $quantotal): self
    {
        $this->quantotal = $quantotal;
        
        return $this;
    }

    public function getPrecoVenda(): ?int
    {
        return $this->precoVenda;
    }

    public function setPrecoVenda(int $precoVenda): self
    {
        $this->precoVenda = $precoVenda;
        
        return $this;
    }

    public function acrescentaQuantidade(int $quantidade): self
    {
        $this->quantotal += $quantidade;
        
        return $this;
    }
}