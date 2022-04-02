<?php

namespace App\Entity;

use PDOException;

class Estoque
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $id_produto;

    /**
     * @var integer
     */
    private $quantotal;

    /**
     * @var float
     */
    private $preco_ven;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantotal(): ?int
    {
        return $this->quantotal;
    }

    public function setQuantotal(int $quantotal): self
    {
        $this->quantotal = $quantotal;
        
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

    /**
     * Acrecenta valor ao estoque quando adiciona um novo produto venda
     */
    public function acrescentaQuantidade(int $quantidade): self
    {
        $this->quantotal += $quantidade;
        
        return $this;
    }
    
    /**
     * Sempre verifica o preço de venda maior para manter no estoque
     */
    public function verificaPrecoVenda(float $ven): ?float
    {
        if($this->preco_ven > $ven){
            return $this->preco_ven;
        } else{
            return $ven;
        }
    }
    
}