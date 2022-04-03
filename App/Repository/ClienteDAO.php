<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Cliente;

use PDO;

class ClienteDAO extends Conexao
{
    public function adicionarCliente($dados)
    {
        $usuario = $_SESSION['usuario']->getId();
        $stmt = static::getConexao()->prepare("INSERT INTO cliente (id_usuario, nome, sobrenome, telefone, email, cpf) VALUES (:usuario, :nome, :sobrenome, :telefone, :email, :cpf)");
        
        $stmt->bindParam(':usuario', $usuario , PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function exibirClientes()
    {
        $stmt = static::getConexao()->query("SELECT * FROM cliente");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function pesquisarClientes($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT id, cpf AS 'text', nome, sobrenome FROM cliente WHERE cpf LIKE :cpf");
        $stmt->bindValue(':cpf', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
