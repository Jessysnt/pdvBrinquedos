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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     */
    public function gravarComandaFatura($respComandaFatura)
    {
        $bd = static::getConexao();

        $sqlCliente = ['',''];
        if(array_key_exists('cliente', $respComandaFatura)){
            $sqlCliente = [', id_cliente',', :idCliente'];
        }
        // die(var_dump($respComandaFatura));
        
        $stmt=$bd->prepare("SELECT id FROM comandafatura WHERE numero = :numero");
        $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($resp != false){
            return $resp['id'];
        }else{
            $sql = "INSERT INTO comandafatura (id_vendedor, numero$sqlCliente[0], data_registro) VALUES (:idVendedor, :numero$sqlCliente[1], :dataRegistro)";
            $stmt=$bd->prepare($sql);
            $stmt->bindParam(':idVendedor', $respComandaFatura['id_vendedor'], PDO::PARAM_INT);
            $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
            if(array_key_exists('cliente', $respComandaFatura)){
                $stmt->bindParam(':idCliente', $respComandaFatura['cliente'], PDO::PARAM_INT);
            }
            $stmt->bindValue(':dataRegistro', $respComandaFatura['dataRegistro']);
            $stmt->execute();
            $resp = $bd->lastInsertId();
            return $resp;
        }
    }

    public function gravarLinhaFatura($linhaFatura)
    {
        $stmt=static::getConexao()->prepare("SELECT id_produto FROM linhafatura WHERE id_comanda_fatura = :id_comanda_fatura AND id_produto =:id_produto");
        $stmt->bindParam(':id_comanda_fatura', $linhaFatura['id_comanda_fatura'], PDO::PARAM_INT);
        $stmt->bindParam(':id_produto', $linhaFatura['id_produto'], PDO::PARAM_INT);
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($resp != false){
            if($resp['id_produto'] == $linhaFatura['id_produto']){
                $stmt=static::getConexao()->prepare("UPDATE linhafatura SET quantidade =:quantidade, valor_unitario =:valor_unitario WHERE id_comanda_fatura = :id_comanda_fatura AND id_produto =:id_produto");
                $stmt->bindParam(':id_comanda_fatura', $linhaFatura['id_comanda_fatura'], PDO::PARAM_INT);
                $stmt->bindParam(':id_produto', $linhaFatura['id_produto'], PDO::PARAM_INT);
                $stmt->bindParam(':quantidade', $linhaFatura['quantidade'], PDO::PARAM_INT);
                $stmt->bindParam(':valor_unitario', $linhaFatura['valor_unitario'], PDO::PARAM_STR);
                return $stmt->execute();
            }
        }
        if($resp == false){
            $stmt=static::getConexao()->prepare("INSERT INTO linhafatura (id_comanda_fatura, id_produto, quantidade, valor_unitario) VALUES (:id_comanda_fatura, :id_produto, :quantidade, :valor_unitario)");
            $stmt->bindParam(':id_comanda_fatura', $linhaFatura['id_comanda_fatura'], PDO::PARAM_INT);
            $stmt->bindParam(':id_produto', $linhaFatura['id_produto'], PDO::PARAM_INT);
            $stmt->bindParam(':quantidade', $linhaFatura['quantidade'], PDO::PARAM_INT);
            $stmt->bindParam(':valor_unitario', $linhaFatura['valor_unitario'], PDO::PARAM_STR);
            return $stmt->execute();
        }
    }

    /**
     * Ve a comanda se esta aberta .. 
     */
    public function verEstaAberta($numero)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM comandafatura where numero = :numero AND comanda_aberta = 1");
        $stmt->bindValue(':numero', $numero);
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        if($resp){
            if($resp['comanda_aberta'] == 1){
                return $resp;
            }
            if($resp['comanda_aberta'] == 0){
                echo 'fechada';
            }
        }else{
            return false;
        } 
    }

    /**
     * Deleta produtos da tabela temporaria
     */
    public function deletarProdutoComanda($post)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM linhafatura WHERE id_comanda_fatura = :id_comanda_fatura");
        $stmt->bindParam(':id_comanda_fatura', $post, PDO::PARAM_INT);
		return $stmt->execute();
    }
}