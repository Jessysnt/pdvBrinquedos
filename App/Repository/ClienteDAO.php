<?php

namespace App\Repository;

use App\Repository\Conexao;

use PDO;

class ClienteDAO extends Conexao
{
    public function adicionarCliente($dados)
    {
        $stmt = static::getConexao()->prepare("INSERT INTO cliente (nome, sobrenome, endereco, email, telefone, cpf) VALUES (:nome, :sobrenome, :endereco, :email, :telefone, :cpf)");
        
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $dados['endereco'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function exibirClientes()
    {
        $stmt = static::getConexao()->query("SELECT * FROM cliente");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
