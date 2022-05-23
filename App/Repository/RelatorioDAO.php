<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class RelatorioDAO extends Conexao
{
    public function maisVendidos($datas)
    {
        $stmt = static::getConexao()->prepare("SELECT p.nome, COUNT(cf.id) as totalVendas, SUM(lf.quantidade) as quantidadeVendida, SUM(lf.quantidade * lf.valor_unitario - (CASE WHEN lf.desconto IS NULL THEN 0 ELSE lf.desconto END)) as totalLiquido
        FROM comandafatura as cf
        INNER JOIN linhafatura as lf ON cf.id = lf.id_comanda_fatura
        INNER JOIN produto as p ON lf.id_produto = p.id
        WHERE cf.data_finalizacao between :dtInicial AND :dtFinal GROUP BY p.id ORDER BY quantidadeVendida desc");
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}