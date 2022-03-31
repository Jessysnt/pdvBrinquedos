<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;
use App\Entity\Estoque;
use PDOException;

class EstoqueDAO extends Conexao
{
    public function mostrarEstoque()
    {
        $stmt = static::getConexao()->query("SELECT pro.nome, pro.descricao,es.quantotal, es.preco_ven, es.id from estoque as es inner join produto as pro on es.id_produto=pro.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizaProdEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("UPDATE estoque SET quantotal=:quantotal, preco_ven=:precoVenda WHERE id=:idEstoque");

        $stmt->bindParam(':idEstoque', $dados['idEstoque'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);
                        
        return $stmt->execute();
    }

    public function addProdEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO estoque (id_produto, quantotal, preco_ven) VALUES (:idProduto, :quantotal, :precoVenda)");

        $stmt->bindParam(':idProduto', $dados['idProduto'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function retornaProdEst($idProduto)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM estoque WHERE id_produto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('\App\Entity\Estoque');
    }
    
}