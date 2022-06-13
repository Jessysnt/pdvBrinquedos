<?php

namespace App\Repository;

use PDO;

class FornecedorDAO extends Conexao
{
    public function tabFornecedor($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM fornecedor WHERE fantasia LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS,'\App\Entity\Fornecedor');
    }

    public function qntTotalFornecedor($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM fornecedor WHERE fantasia LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarFornecedor($dados)
    {
        $idUsuario=$_SESSION['usuario']->getId();
        $stmt = static::getConexao()->prepare("INSERT INTO fornecedor (razao_social, fantasia, cnpj, email, telefone, rua, numero, bairro, cidade, cep, estado, id_usuario) VALUES (:social, :fantasia, :cnpj, :email, :telefone, :rua, :numero, :bairro, :cidade, :cep, :estado, :idUsuario)");
        $stmt->bindParam(':social', $dados['razao_social'], PDO::PARAM_STR);
        $stmt->bindParam(':fantasia', $dados['fantasia'], PDO::PARAM_STR);
        $stmt->bindParam(':cnpj', $dados['cnpj'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':rua', $dados['rua'], PDO::PARAM_STR);
        $stmt->bindParam(':numero', $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $dados['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(':cep', $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterFornecedor($fornecedor)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM fornecedor WHERE id=:id");
        $stmt->bindParam(':id', $fornecedor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizaFornecedor($fornecedor)
    {
        $stmt=static::getConexao()->prepare("UPDATE fornecedor SET razao_social=:razao_social, fantasia=:fantasia, cnpj=:cnpj, email=:email, telefone=:telefone, rua=:rua, numero=:numero, bairro=:bairro, cep=:cep,cidade=:cidade, estado=:estado WHERE id=:id");
        $stmt->bindParam(':id', $fornecedor['id'], PDO::PARAM_INT);
        $stmt->bindParam(':razao_social', $fornecedor['razao_social'], PDO::PARAM_STR);
        $stmt->bindParam(':fantasia', $fornecedor['fantasia'], PDO::PARAM_STR);
        $stmt->bindParam(':cnpj', $fornecedor['cnpj'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $fornecedor['email'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $fornecedor['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':rua', $fornecedor['rua'], PDO::PARAM_STR);
        $stmt->bindParam(':numero', $fornecedor['numero'], PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $fornecedor['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(':cep', $fornecedor['cep'], PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $fornecedor['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $fornecedor['estado'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function apagarFornecedor($fornecedor)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM fornecedor WHERE id=:id");
        $stmt->bindParam(':id', $fornecedor, PDO::PARAM_INT);
        return $stmt->execute();
    }
}