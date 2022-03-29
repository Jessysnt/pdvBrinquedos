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
    private $email;

    /**
     * @var string
     */
    private $senha;

    /**
     * @var integer
     */
    private $cargo;

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

    public function getCargo(): ?int
    {
        return $this->cargo;
    }

    public function setCargo(int $cargo): self
    {
        $this->cargo = $cargo;
        
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


    /**
     * Metodo para consulta do login
     * @return boolean
     */
    public function logar(){
        $obUsuario = new UsuarioDAO;
        $obUsuario->login([
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }

    public function primeiroRegistro(){
        $obUsuario = new UsuarioDAO;
        $obUsuario->registroUsuario([
            'nome' => $this->nome,
            'sobrenome' => $this->sobrenome,
            'email' => $this->email,
            'senha' => $this->senha,
            'cargo' => $this->cargo
        ]);
    }

}