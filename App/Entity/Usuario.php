<?php

namespace App\Entity;

use App\DAO\UsuarioDAO;
use DateTime;
use PDO;

class Usuario {

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
    private $sobrenome;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $senha;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var string
     */
    private $acesso;

    /**
     * @var string
     */
    private $status;

    /**
     * @var DateTime
     */
    private $registro;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSobrenome(): ?string
    {
        return $this->sobrenome;
    }

    public function setSobrenome(string $sobrenome): self
    {
        $this->sobrenome = $sobrenome;
        
        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;
        
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

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;
        
        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(string $cargo): self
    {
        $this->cargo = $cargo;
        
        return $this;
    }

    public function getAcesso(): ?string
    {
        return $this->acesso;
    }

    public function setAcesso(string $acesso): self
    {
        $this->acesso = $acesso;
        
        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        
        return $this;
    }

    public function getRegistro(): DateTime
    {
        return $this->registro;
    }

    public function getNomeCompleto(): ?string
    {
        return $this->nome.' '.$this->sobrenome;
    }

    // public function getCargoNome(): ?string
    // {
    //     switch ($this->cargo) {
    //         case '1':
    //             return 'Administrador';
    //             break;
    //         case '2':
    //             return 'Gerente';
    //             break;
    //         case '3':
    //             return 'Caixa';
    //             break;
    //         case '4':
    //             return 'Vendedor';
    //             break;
    //         default:
    //             return 'Cargo não encontrado.';
    //             break;
    //     }
    // }


    public function getAcessos()
    {
        $var = array_map('intval', explode(', ',$this->acesso));
        array_unshift($var, 0) ;
        return  $var;
    }




}