<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;
use PDOException;

class ProdutoVendaDAO extends Conexao
{
    public function adicionarProdVenda($dadosP)
    {
        $bd = static::getConexao();
        $stmt=$bd->prepare("INSERT INTO produtovenda (id_usuario, id_produto, lote, quantidade, preco_comp, preco_ven) VALUES (:idUsuario, :idProduto, :lote, :quantotal, :precoComp, :precoVenda)");
        $stmt->bindParam(':idUsuario', $dadosP['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':idProduto', $dadosP['idProduto'], PDO::PARAM_INT);
        $stmt->bindParam(':lote', $dadosP['lote'], PDO::PARAM_STR);
        $stmt->bindParam(':quantotal', $dadosP['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoComp', $dadosP['precoComp'], PDO::PARAM_STR);
        $stmt->bindParam(':precoVenda', $dadosP['precoVenda'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function produtoVendaTabela()
    {
        $stmt = static::getConexao()->query("SELECT pro.id AS idProduto, pro.nome, pro.codigo, pv.lote, pv.quantidade, pv.preco_comp, pv.preco_ven, pv.id FROM produtovenda AS pv INNER JOIN produto AS pro ON pv.id_produto=pro.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obterProdutoVenda($dados)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM produtovenda WHERE id=:id");
        $stmt->bindParam(':id', $dados['idprodv'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarProdutoV($dados)
    {
        $stmt=static::getConexao()->prepare("UPDATE produto SET id_produto=:idProduto, lote=:lote, quantidade=:quantidade, preco_comp=:precoCompU, preco_ven=:precoVenU, editado=:editado WHERE id=:id");
        $stmt->bindParam(':id', $dados['idprodvU'], PDO::PARAM_INT);
        $stmt->bindParam(':idProduto', $dados['idProdutoU'], PDO::PARAM_INT);
        $stmt->bindParam(':lote', $dados['loteU'], PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $dados['quantidadeU'], PDO::PARAM_INT);
        $stmt->bindParam(':precoCompU', $dados['compU'], PDO::PARAM_STR);
        $stmt->bindParam(':precoVenU', $dados['venU'], PDO::PARAM_STR);
        // $stmt->bindValue(':editado', );
        die(var_dump($stmt->execute()));
        return $stmt->execute();
    }

    public function deletarProdutoVenda($idprodv)
    {   
        $stmt=static::getConexao()->prepare("DELETE FROM produtovenda WHERE id=:id");
        $stmt->bindParam(':id', $idprodv, PDO::PARAM_INT);
		return $stmt->execute();
    }
}