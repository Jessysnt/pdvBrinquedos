<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;
use App\Entity\Estoque;
use PDOException;

class EstoqueDAO extends Conexao
{
    public function mostrarEstoque($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        // die(var_dump($offset));
        $stmt = static::getConexao()->prepare("SELECT pro.nome, pro.descricao,es.quantotal, es.preco_ven, es.id FROM estoque AS es INNER JOIN produto AS pro ON es.id_produto=pro.id WHERE pro.nome LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function qntTotalEstoque($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(es.id) AS total FROM estoque AS es INNER JOIN produto AS pro ON es.id_produto=pro.id WHERE pro.nome LIKE :busca LIMIT 1 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizaProdEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("UPDATE estoque SET quantotal=:quantotal, preco_ven=:precoVenda WHERE id=:idEstoque");
        $stmt->bindParam(':idEstoque', $dados['idEstoque'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);            
        return $stmt->execute();
    }

    public function addProdEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO estoque (id_produto, quantotal, preco_ven) VALUES (:idProduto, :quantotal, :precoVenda)");
        $stmt->bindParam(':idProduto', $dados['idProduto'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);
        $stmt->bindParam(':precoVenda', $dados['precoVenda'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Retorna produto estoque
     */
    public function retornaProdEst($idProduto)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM estoque WHERE id_produto = :idProduto");
        $stmt->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('\App\Entity\Estoque');
    }

    /**
     * Retorna quantidade produto estoque e quantidade do produto no lote
     */
    public function retornaEstoqueLote($Produto)
    {
        $stmt = static::getConexao()->prepare("SELECT es.id as ides, es.quantotal, es.preco_ven, pv.id as idpv, pv.quantidade, pv.preco_ven FROM estoque AS es LEFT JOIN produtovenda AS pv ON es.id_produto=pv.id_produto WHERE es.id_produto = :idProduto AND  pv.id = :idProdVend");
        $stmt->bindParam(':idProduto', $Produto['idProduto'], PDO::PARAM_INT);
        $stmt->bindParam(':idProdVend', $Produto['idProdVend'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * Apaga a quantidade no estoque quando a tabela produto-venda apaga o produto
     */
    public function apagaEstoquePV($dados)
    {   
        // die(var_dump($dados['id_produto']));
        $stmt=static::getConexao()->prepare("UPDATE estoque SET quantotal=:quantotal WHERE id_produto=:idProduto");
        $stmt->bindParam(':idProduto', $dados['id_produto'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);                
        return $stmt->execute();
    }

    /**
     * Baixa atraves da venda
     */
    public function baixaEstoque($dados)
    {
        $stmt=static::getConexao()->prepare("UPDATE estoque SET quantotal=:quantotal WHERE id=:idEstoque");
        $stmt->bindParam(':idEstoque', $dados['idEstoque'], PDO::PARAM_INT);
        $stmt->bindParam(':quantotal', $dados['quantotal'], PDO::PARAM_INT);           
        return $stmt->execute();
    }
    
}