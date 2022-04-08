<?php

namespace App\Repository;

use App\Repository\Conexao;
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
        $stmt = static::getConexao()->prepare("SELECT pro.nome AS nomeProduto, pro.descricao as descricaoV, lf.quantidade AS quantV, lf.valor_unitario AS precoV, lf.*, pro.* FROM linhafatura AS lf INNER JOIN produto AS pro ON lf.id_produto = pro.id where id_comanda_fatura = :idComandaFatura");
        $stmt->bindValue(':idComandaFatura', $idComandaFatura);
        $stmt->execute();
        // die(var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}