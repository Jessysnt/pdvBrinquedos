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

        $stmt=$bd->prepare("SELECT id FROM comandafatura WHERE numero = :numero");
        $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
        $stmt->execute();
        $resp = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($resp != false){
            if($sqlCliente[0] != ""){
                $stmt=static::getConexao()->prepare("UPDATE comandafatura SET id_cliente = :idCliente, data_registro = :dataRegistro WHERE id= :id");
                $stmt->bindParam(':id', $resp['id'], PDO::PARAM_INT);
                $stmt->bindParam(':idCliente', $respComandaFatura['cliente'], PDO::PARAM_INT);
                $stmt->bindValue(':dataRegistro', $respComandaFatura['dataRegistro']);
                $stmt->execute();
            }
            return $resp['id'];
        }else{
            // die(var_dump($respComandaFatura));
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

    public function gravarLinhaFaturaInsert($linhaFatura)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO linhafatura (id_comanda_fatura, id_produto, quantidade, valor_unitario) VALUES (:id_comanda_fatura, :id_produto, :quantidade, :valor_unitario)");
        $stmt->bindParam(':id_comanda_fatura', $linhaFatura['id_comanda_fatura'], PDO::PARAM_INT);
        $stmt->bindParam(':id_produto', $linhaFatura['id_produto'], PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $linhaFatura['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':valor_unitario', $linhaFatura['valor_unitario'], PDO::PARAM_STR);
        return $stmt->execute();
        
    }

    public function deletarLinhaFatura($comandafatura)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM linhafatura WHERE id_comanda_fatura = :id_comanda_fatura");
        $stmt->bindParam(':id_comanda_fatura', $comandafatura, PDO::PARAM_INT);
		return $stmt->execute();
    }

    /**
     * Ve a comanda se esta aberta .. 
     */
    public function verEstaAberta($numero)
    {
        $datas['dtInicial'] = $numero['dtInicial'].' 00:00:00';
        $datas['dtFinal'] = $numero['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT * FROM comandafatura where numero = :numero AND data_registro BETWEEN :dtInicial AND :dtFinal");
        $stmt->bindValue(':numero', $numero['numero']);
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
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

    public function fecharComanda($comanda)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM comandafatura WHERE id = :comanda");
        $stmt->bindParam(':comanda', $comanda, PDO::PARAM_INT);
		return $stmt->execute();
    }

    public function fecharLinhaFatura($comanda)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM linhafatura WHERE id_comanda_fatura = :comanda");
        $stmt->bindParam(':comanda', $comanda, PDO::PARAM_INT);
		return $stmt->execute();
    }
}