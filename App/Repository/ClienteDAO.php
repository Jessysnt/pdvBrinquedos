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

    /**
     * Dados passado para a tela cliente-venda
     */
    public function exibirCliente($idCliente)
    {
        $stmt = static::getConexao()->prepare("SELECT id, nome, sobrenome, cpf FROM cliente WHERE id=:id");
        $stmt->bindParam(':id', $idCliente, PDO::PARAM_INT);
        $stmt->execute(); 
        return $stmt->fetchObject('\App\Entity\Cliente');
    }

    /**
     * Manda os dados para o select da comanda
     */
    public function pesquisarClientes($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT id, cpf AS 'text', nome, sobrenome FROM cliente WHERE cpf LIKE :cpf");
        $stmt->bindValue(':cpf', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exibe o cliente da comanda
     */
    public function pesquisarClienteComanda($cliente)
    {
        $stmt = static::getConexao()->prepare("SELECT id, cpf, nome, sobrenome FROM cliente WHERE id = :id AND status=1");
        $stmt->bindParam(':id', $cliente , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tabClientes($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM cliente WHERE nome LIKE :busca AND status=1 LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function qntTotalClientes($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM cliente WHERE nome LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function inativarCliente($cliente)
    {
        $stmt = static::getConexao()->prepare("UPDATE cliente SET status=0 WHERE id = :id");
        $stmt->bindParam(':id', $cliente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterCliente($cliente)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM cliente WHERE id=:id");
        $stmt->bindParam(':id', $cliente['idcliente'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarCliente($cliente)
    {
        $stmt=static::getConexao()->prepare("UPDATE cliente SET nome=:nome, sobrenome=:sobrenome, email=:email, telefone=:telefone WHERE id=:id");
        $stmt->bindParam(':id', $cliente['idclienteU'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $cliente['nomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $cliente['sobrenomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $cliente['emailU'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $cliente['telefoneU'], PDO::PARAM_STR);
        // $stmt->bindParam(':cpf', $cliente['cpfU'], PDO::PARAM_STR);         
        return $stmt->execute();
	}

    public function vendaClienteData($usuario)
    {
        $stmt = static::getConexao()->prepare("SELECT numero, valor_total1, valor_total2, data_finalizacao  FROM comandafatura WHERE data_finalizacao BETWEEN :dtInicial AND :dtFinal AND id_cliente=:idCliente");
        $stmt->bindParam(':idCliente', $usuario['idCliente'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $usuario['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $usuario['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
