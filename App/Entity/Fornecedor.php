<?php

namespace App\Entity;

use App\DAO\UsuarioDAO;
use DateTime;
use PDO;

class Fornecedor
{
     /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $razao_social;

    /**
     * @var string
     */
    private $fantasia;

    /**
     * @var string
     */
    private $cnpj;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $telefone;

    /**
     * @var string
     */
    private $rua;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var string
     */
    private $bairro;

    /**
     * @var string
     */
    private $cidade;

    /**
     * @var string
     */
    private $estado;

    /**
     * @var string
     */
    private $cep;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazao_social(): ?string
    {
        return $this->razao_social;
    }

    public function setRazao_social(string $razao_social): self
    {
        $this->razao_social = $razao_social;

        return $this;
    }

    public function getFantasia(): ?string
    {
        return $this->fantasia;
    }

    public function setFantasia(string $fantasia): self
    {
        $this->fantasia = $fantasia;
        
        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;
        
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        
        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): self
    {
        $this->telefone = $telefone;
        
        return $this;
    }

    public function getRua(): ?string
    {
        return $this->rua;
    }

    public function setRua(string $rua): self
    {
        $this->rua = $rua;
        
        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;
        
        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;
        
        return $this;
    }

    public function getCidade(): ?string
    {
        return $this->cidade;
    }

    public function setCidade(string $cidade): self
    {
        $this->cidade = $cidade;
        
        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;
        
        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(string $cep): self
    {
        $this->cep = $cep;
        
        return $this;
    }

    public function getEndereco()
    {
        return $this->rua.', '.$this->numero.' - '.$this->bairro.' - '.$this->cep;
    }

    public function getCidadeEstado()
    {
        return $this->cidade.' - '.$this->estado;
    }
}