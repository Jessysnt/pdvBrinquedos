<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Comanda;
use PDO;

class PdvDAO extends Conexao
{
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
     * Comanda aberta tras os produtos para colocar na tabela temporaria
     */
    public function verProdutoLinha($idComandaFatura)
    {
        $stmt = static::getConexao()->prepare("SELECT pro.id AS produtoVenda, pro.nome AS nomeProduto, pro.descricao as descricaoV, lf.quantidade AS quantV, lf.valor_unitario AS precoV, lf.*, pro.* FROM linhafatura AS lf INNER JOIN produto AS pro ON lf.id_produto = pro.id where id_comanda_fatura = :idComandaFatura");
        $stmt->bindValue(':idComandaFatura', $idComandaFatura);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Gravar fatura com numero de comanda
     */
    public function gravarComandaFatura($respComandaFatura)
    {
        // die(var_dump($respComandaFatura));
        $bd = static::getConexao();

        $sqlCliente = ['',''];
        if(array_key_exists('cliente', $respComandaFatura)){
            $sqlCliente = ['id_cliente=',':cliente, '];
        }

        $sqlFormaPgDois = ['',''];
        if(array_key_exists('formaPgDois', $respComandaFatura)){
            $sqlFormaPgDois = [' pg_forma2=',':formaPgDois, '];
        }

        $sqlValorTotalDois = ['',''];
        if(array_key_exists('valorTotalDois', $respComandaFatura)){
            $sqlValorTotalDois = [' valor_total2=',':valorTotalDois, '];
        }

        $sqlVzsCartao = ['',''];
        if(array_key_exists('vzsCartao', $respComandaFatura)){
            $sqlVzsCartao = [' vzs_cartao=',':vzsCartao, '];
        }

        $LastUpdateID = "SELECT id FROM comandafatura WHERE numero = :numero";
        $sql = "UPDATE comandafatura SET $sqlCliente[0]$sqlCliente[1]pg_forma1=:formaPgUm, valor_total1=:valorTotalUm,$sqlFormaPgDois[0]$sqlFormaPgDois[1]$sqlValorTotalDois[0]$sqlValorTotalDois[1]$sqlVzsCartao[0]$sqlVzsCartao[1]comanda_aberta=0, id_caixa =:idCaixa, data_finalizacao=:dataFinalizacao WHERE numero = :numero";
        
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(':idCaixa', $respComandaFatura['id_caixa'], PDO::PARAM_INT);
        $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
        if(array_key_exists('cliente', $respComandaFatura)){
            $stmt->bindParam(':cliente', $respComandaFatura['cliente'], PDO::PARAM_INT);
        }
        $stmt->bindParam(':formaPgUm', $respComandaFatura['formaPgUm'], PDO::PARAM_INT);
        $stmt->bindParam(':valorTotalUm', $respComandaFatura['valorTotalUm'], PDO::PARAM_STR);
        if(array_key_exists('formaPgDois', $respComandaFatura)){
            $stmt->bindParam(':formaPgDois', $respComandaFatura['formaPgDois'], PDO::PARAM_INT);
        }
        if(array_key_exists('valorTotalDois', $respComandaFatura)){
            $stmt->bindParam(':valorTotalDois', $respComandaFatura['valorTotalDois'], PDO::PARAM_STR);
        }
        if(array_key_exists('vzsCartao', $respComandaFatura)){
            $stmt->bindParam(':vzsCartao', $respComandaFatura['vzsCartao'], PDO::PARAM_INT);
        }
        $stmt->bindValue(':dataFinalizacao', $respComandaFatura['dataFinalizacao']);
        // die(var_dump($respComandaFatura));
        $result = $stmt->execute(); 

        if($result == true){
            $stmt=$bd->prepare($LastUpdateID);
            $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
            $stmt->execute();
            $resp = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resp['id'];
        }
    }

    /**
     * Gravar fatura sem numero de comanda
     */
    public function gravarComandaFaturaSemNumero($respComandaFatura)
    {
        $bd = static::getConexao();

        $sqlCliente = ['',''];
        if(array_key_exists('cliente', $respComandaFatura)){
            $sqlCliente = [', id_cliente',', :idCliente'];
        }

        $sqlFormaPgDois = ['',''];
        if(array_key_exists('formaPgDois', $respComandaFatura)){
            $sqlFormaPgDois = [', pg_forma2',', :formaPgDois'];
        }

        $sqlValorTotalDois = ['',''];
        if(array_key_exists('valorTotalDois', $respComandaFatura)){
            $sqlValorTotalDois = [', valor_total2',', :valorTotalDois'];
        }

        $sqlVzsCartao = ['',''];
        if(array_key_exists('vzsCartao', $respComandaFatura)){
            $sqlVzsCartao = [', vzs_cartao',', :vzsCartao'];
        }

        $sql = "INSERT INTO comandafatura (id_caixa$sqlCliente[0], pg_forma1, valor_total1$sqlFormaPgDois[0]$sqlValorTotalDois[0]$sqlVzsCartao[0], comanda_aberta, data_finalizacao) VALUES (:idCaixa$sqlCliente[1], :formaPgUm, :valorTotalUm$sqlFormaPgDois[1]$sqlValorTotalDois[1]$sqlVzsCartao[1], :comanda_aberta, :dataFinalizacao)";

        $stmt=$bd->prepare($sql);
        $stmt->bindParam(':idCaixa', $respComandaFatura['id_caixa'], PDO::PARAM_INT);
        if(array_key_exists('cliente', $respComandaFatura)){
            $stmt->bindParam(':idCliente', $respComandaFatura['id_cliente'], PDO::PARAM_INT);
        }
        $stmt->bindParam(':formaPgUm', $respComandaFatura['formaPgUm'], PDO::PARAM_INT);
        $stmt->bindParam(':valorTotalUm', $respComandaFatura['valorTotalUm'], PDO::PARAM_STR);
        if(array_key_exists('formaPgDois', $respComandaFatura)){
            $stmt->bindParam(':formaPgDois', $respComandaFatura['formaPgDois'], PDO::PARAM_INT);
        }
        if(array_key_exists('valorTotalDois', $respComandaFatura)){
            $stmt->bindParam(':valorTotalDois', $respComandaFatura['valorTotalDois'], PDO::PARAM_STR);
        }
        if(array_key_exists('vzsCartao', $respComandaFatura)){
            $stmt->bindParam(':vzsCartao', $respComandaFatura['vzsCartao'], PDO::PARAM_INT);
        }
        $stmt->bindValue(':comanda_aberta', 0);
        $stmt->bindValue(':dataFinalizacao', $respComandaFatura['dataFinalizacao']);
        $stmt->execute();
        $resp = $bd->lastInsertId();
        return $resp;
    }

    /**
     * Gravar produtos, preços e quantidade
     */
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
     * Deleta produtos da tabela temporaria
     */
    public function deletarProdutoComanda($post)
    {
        $stmt=static::getConexao()->prepare("DELETE FROM linhafatura WHERE id_comanda_fatura = :id_comanda_fatura");
        $stmt->bindParam(':id_comanda_fatura', $post, PDO::PARAM_INT);
		return $stmt->execute();
    }

    public function tabelaComprovante()
    {
        $stmt=static::getConexao()->prepare("SELECT id FROM comandafatura WHERE data_finalizacao is not null ORDER BY id DESC LIMIT 1");
		$resp= $stmt->execute();

        if($resp){
            $stmt = static::getConexao()->prepare("SELECT cf.id, cf.numero, date_format(cf.data_finalizacao, '%d-%m-%Y - %H:%i:%s') as venda, (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) WHEN cf.valor_total1 IS NULL THEN SUM(lf.quantidade * lf.valor_unitario) ELSE cf.valor_total1 END ) AS total, GROUP_CONCAT(CONCAT(lf.quantidade,'x ',p.nome,' val.:',lf.valor_unitario,' desc.:', COALESCE(lf.desconto, 0))) as item, CONCAT(c.nome, ' ',c.sobrenome) as cliente, CONCAT(u.nome, ' ',u.sobrenome) as vendedor
            FROM comandafatura AS cf
            INNER JOIN linhafatura AS lf ON cf.id = lf.id_comanda_fatura
            INNER JOIN produto AS p ON lf.id_produto = p.id
            LEFT JOIN cliente as c ON cf.id_cliente = c.id
            LEFT JOIN usuario as u ON cf.id_vendedor = u.id
            WHERE  cf.id = :idVenda
            GROUP BY cf.id ");
            $stmt->bindParam(':idVenda', $resp, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}