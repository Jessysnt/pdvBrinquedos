<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Comanda;
use PDO;

class PdvDAO extends Conexao
{
    public function verEstaAberta($numero)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM comandafatura where numero = :numero AND comanda_aberta = 1");
        $stmt->bindValue(':numero', $numero);
        $stmt->execute();
        // die(var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verProdutoLinha($idComandaFatura)
    {
        $stmt = static::getConexao()->prepare("SELECT pro.id AS produtoVenda, pro.nome AS nomeProduto, pro.descricao as descricaoV, lf.quantidade AS quantV, lf.valor_unitario AS precoV, lf.*, pro.* FROM linhafatura AS lf INNER JOIN produto AS pro ON lf.id_produto = pro.id where id_comanda_fatura = :idComandaFatura");
        $stmt->bindValue(':idComandaFatura', $idComandaFatura);
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

        // $sqlNumero = ['',''];
        // if(array_key_exists('numero', $respComandaFatura)){
        //     $sqlNumero = [', numero',', :numero'];
        // }
        $sqlCliente = ['',''];
        if(array_key_exists('cliente', $respComandaFatura)){
            $sqlCliente = ['id_cliente=',':cliente, '];
        }

        $sqlFormaPgDois = ['',''];
        if(array_key_exists('formaPgDois', $respComandaFatura)){
            $sqlFormaPgDois = ['pg_forma2=',':formaPgDois, '];
        }

        $sqlValorTotalDois = ['',''];
        if(array_key_exists('valorTotalDois', $respComandaFatura)){
            $sqlValorTotalDois = ['valor_total2=',':valorTotalDois, '];
        }

        $sqlVzsCartao = ['',''];
        if(array_key_exists('vzsCartao', $respComandaFatura)){
            $sqlVzsCartao = ['vzs_cartao=',':vzsCartao, '];
        }
        // die(var_dump($respComandaFatura));
        $sql = "UPDATE comandafatura SET $sqlCliente[0]$sqlCliente[1] pg_forma1=:formaPgUm, valor_total1=:valorTotalUm, $sqlFormaPgDois[0]$sqlFormaPgDois[1]$sqlValorTotalDois[0]$sqlValorTotalDois[1]$sqlVzsCartao[0]$sqlVzsCartao[1]comanda_aberta=0 WHERE numero = :numero";

            $stmt=$bd->prepare($sql);
            // $stmt->bindParam(':idUsuario', $respComandaFatura['id_usuario'], PDO::PARAM_INT);
            $stmt->bindParam(':numero', $respComandaFatura['numero'], PDO::PARAM_STR);
            // die(var_dump($respComandaFatura['numero']));
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
            
            $stmt->execute();
            $resp = $stmt->fetch(PDO::FETCH_ASSOC, 'App\Entity\Comanda', $id->getId());
            die(var_dump($resp));
            // return $resp;
        
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