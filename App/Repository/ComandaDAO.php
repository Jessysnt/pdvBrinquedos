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
}