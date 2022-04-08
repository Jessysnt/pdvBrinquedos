<?php

namespace App\Entity;

class Comanda 
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
    private $id_cliente;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var bool
     */
    private $comanda_aberta;

    /**
     * @var int
     */
    private $pg_forma1;

    /**
     * @var float
     */
    private $valor_total1;

    /**
     * @var int
     */
    private $pg_forma2;

    /**
     * @var float
     */
    private $valor_total2;

    /**
     * @var int
     */
    private $vzs_cartao;

    /**
     * @var string
     */
    private $bandeira_cartao;


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

    public function getIdCliente(): ?int
    {
        return $this->id_cliente;
    }

    public function setIdCliente(int $id_cliente): self
    {
        $this->id_cliente = $id_cliente;
        
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

    public function getComandaAberta(): ?bool
    {
        return $this->comanda_aberta;
    }

    public function setComandaAberta(bool $comanda_aberta): self
    {
        $this->comanda_aberta = $comanda_aberta;

        return $this;
    }

    public function getPgForma1(): ?int
    {
        return $this->pg_forma1;
    }

    public function setPgForma1(int $pg_forma1): self
    {
        $this->pg_forma1 = $pg_forma1;
        
        return $this;
    }

    public function getValorTotal1(): ?float
    {
        return $this->valor_total1;
    }

    public function setValorTotal1(float $valor_total1): self
    {
        $this->valor_total1 = $valor_total1;
        
        return $this;
    }

    public function getPgForma2(): ?int
    {
        return $this->pg_forma2;
    }

    public function setPgForma2(int $pg_forma2): self
    {
        $this->pg_forma2 = $pg_forma2;
        
        return $this;
    }

    public function getValorTotal2(): ?float
    {
        return $this->valor_total2;
    }

    public function setValorTotal2(float $valor_total2): self
    {
        $this->valor_total2 = $valor_total2;
        
        return $this;
    }

    public function getVzsCartao(): ?int
    {
        return $this->vzs_cartao;
    }

    public function setVzsCartao(int $vzs_cartao): self
    {
        $this->vzs_cartao = $vzs_cartao;
        
        return $this;
    }

    public function getBandeiraCartao(): ?int
    {
        return $this->bandeira_cartao;
    }

    public function setBandeiraCartao(int $bandeira_cartao): self
    {
        $this->bandeira_cartao = $bandeira_cartao;
        
        return $this;
    }

}