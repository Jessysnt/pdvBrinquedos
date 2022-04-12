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
     * Pesquisa produtos para trazer no cadastro de comandas pelo entter
     */
    public function pesquisarProdutoVendaCod($codigo)
    {
        $stmt = static::getConexao()->prepare("SELECT pro.id, pro.nome, pro.descricao, es.quantotal, es.preco_ven FROM produto AS pro INNER JOIN estoque AS es ON pro.id=es.id_produto AND pro.codigo = :codigo");
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        // die(var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     */
    public function gravarComandaFatura($respComandaFatura)
    {
        $bd = static::getConexao();

        $sqlNumero = ['',''];
        if(array_key_exists('numero', $respComandaFatura)){
            $sqlNumero = [', numero',', :numero'];
        }
        $sqlCliente = ['',''];
        if(array_key_exists('cliente', $respComandaFatura)){
            $sqlCliente = [', id_cliente',', :idCliente'];
        }

        $sql = "INSERT INTO comandafatura (id_usuario$sqlNumero[0]$sqlCliente[0]) VALUES (:idUsuario$sqlNumero[1]$sqlCliente[1])";

            $stmt=$bd->prepare($sql);

            $stmt->bindParam(':idUsuario', $respComandaFatura['id_usuario'], PDO::PARAM_INT);
            
            if(array_key_exists('numero', $respComandaFatura)){
                $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
            }
            if(array_key_exists('cliente', $respComandaFatura)){
                $stmt->bindParam(':idCliente', $respComandaFatura['id_cliente'], PDO::PARAM_INT);
            }

            $stmt->execute();
            $resp = $bd->lastInsertId();
            
            return $resp;
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

    public function verEstaAberta($numero)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM comandafatura where numero = :numero AND comanda_aberta = 1");
        $stmt->bindValue(':numero', $numero);
        $stmt->execute();
        // die(var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}