<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class ComandaDAO extends Conexao
{
    /**
     * Pesquisa produtos para trazer no cadastro de comandas
     */
    public function pesquisarProdutoVenda($id)
    {
        $stmt = static::getConexao()->prepare("SELECT pro.descricao, es.quantotal, es.preco_ven FROM produto AS pro INNER JOIN estoque AS es ON pro.id=es.id_produto AND pro.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     */
    public function gravarComandaFatura($respComandaFatura)
    {
        $bd = static::getConexao();
        if(array_key_exists('numero', $respComandaFatura) ){
            $stmt=$bd->prepare("INSERT INTO comandafatura (id_usuario, numero) VALUES (:idUsuario, :numero)");
            $stmt->bindParam(':idUsuario', $respComandaFatura['id_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_INT);
            $stmt->execute();
            $resp = $bd->lastInsertId();

            return $resp;
        }else{
            $stmt=$bd->prepare("INSERT INTO comandafatura (id_usuario, id_cliente) VALUES (:idUsuario, :idCliente)");
            $stmt->bindParam(':idUsuario', $respComandaFatura['id_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(':idCliente', $respComandaFatura['id_cliente'], PDO::PARAM_INT);
            $stmt->execute();
            $resp = $bd->lastInsertId();
            
            return $resp;
        }
    }

    public function gravarLinhaFatura($linhaFatura)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO linhafatura (id_comanda_fatura, id_produto, quantidade, valor_unitario) VALUES (:id_comanda_fatura, :id_produto, :quantidade, :valor_unitario)");

        $stmt->bindParam(':id_comanda_fatura', $linhaFatura['id_comanda_fatura'], PDO::PARAM_INT);
        $stmt->bindParam(':id_produto', $linhaFatura['id_produto'], PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $linhaFatura['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':valor_unitario', $linhaFatura['valor_unitario'], PDO::PARAM_STR);

        return $stmt->execute();
    }
}