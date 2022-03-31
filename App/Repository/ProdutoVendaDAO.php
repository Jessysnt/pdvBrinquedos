<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;
use PDOException;

class ProdutoVendaDAO extends Conexao
{
    public function adicionarProdVenda($dadosP)
    {
        try{
            $bd = static::getConexao();
            $stmt=$bd->prepare("INSERT INTO produto_venda (id_usuario, id_produto, lote, quantidade, preco_comp, preco_ven) VALUES (:idUsuario, :idProduto, :lote, :quantotal, :precoComp, :precoVenda)");

            $stmt->bindParam(':idUsuario', $dadosP['idUsuario'], PDO::PARAM_INT);
            $stmt->bindParam(':idProduto', $dadosP['idProduto'], PDO::PARAM_INT);
            $stmt->bindParam(':lote', $dadosP['lote'], PDO::PARAM_STR);
            $stmt->bindParam(':quantotal', $dadosP['quantotal'], PDO::PARAM_INT);
            $stmt->bindParam(':precoComp', $dadosP['precoComp'], PDO::PARAM_STR);
            $stmt->bindParam(':precoVenda', $dadosP['precoVenda'], PDO::PARAM_STR);

            //$resp = $bd->lastInsertId();//tras o ultimo id

            return $stmt->execute();;
        }catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function produtoVendaTabela()
    {
        $stmt = static::getConexao()->query("SELECT pro.nome, pv.lote, pv.quantidade, pv.preco_comp, pv.preco_ven, pv.id FROM produto_venda AS pv INNER JOIN produto AS pro ON pv.id_produto=pro.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}