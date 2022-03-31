<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class ProdutoVendaDAO extends Conexao
{
    public function adicionarProdVenda($dadosP)
    {
        $bd = static::getConexao();
        $stmt=$bd->prepare("INSERT INTO produtovenda (id_usuario, id_produto, lote, quantidade, preco_comp, preco_ven) VALUES (:idUsuario, :idProduto, :lote, :quantidade, :precoComp, :precoVenda)");

        $stmt->bindParam(':idUsuario', $dadosP['idusuario'], PDO::PARAM_INT);
        $stmt->bindParam(':idProduto', $dadosP['produtoSelect'], PDO::PARAM_INT);
        $stmt->bindParam(':lote', $dadosP['lote'], PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $dadosP['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':precoComp', $dadosP['comp'], PDO::PARAM_STR);
        $stmt->bindParam(':precoVenda', $dadosP['ven'], PDO::PARAM_STR);

        $stmt->execute();
        $resp = $bd->lastInsertId();

        return $resp;
    }
}