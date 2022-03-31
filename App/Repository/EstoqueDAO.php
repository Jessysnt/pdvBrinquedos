<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class EstoqueDAO extends Conexao
{
    public function atualizaProdEstoque($dados)
    {
        $quantnova = $dados['quantidade'] + $dados['quantEst'];

        $stmt=static::getConexao()->prepare("UPDATE estoque SET quantotal=:quantnova, preco_ven=:precoVenda WHERE id=:idEstoque");

        $stmt->bindParam(':id', $dados['idEstoque'], PDO::PARAM_INT);
        $stmt->bindParam(':quantnova', $quantnova, PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);
                        
        return $stmt->execute();
    }

    public function addProdEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO estoque (id_produto, quantotal, preco_ven) VALUES (:idEstoque, :quantotal, :precoVenda)");

        $stmt->bindParam(':idEstoque', $dados['idEstoque'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);

        return $stmt->execute();
    }
    
}