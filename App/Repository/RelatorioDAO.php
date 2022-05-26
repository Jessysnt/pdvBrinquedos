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

    public function vendaComandas($datas)
    {
        $datas['dtInicial'] = $datas['dtInicial'].' 00:00:00';
        $datas['dtFinal'] = $datas['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT cf.id, cf.numero, cf.comanda_aberta, date_format(cf.data_registro, '%d-%m-%Y') as abertura, (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) WHEN cf.valor_total1 IS NULL THEN SUM(lf.quantidade * lf.valor_unitario) ELSE cf.valor_total1 END ) AS total, GROUP_CONCAT(CONCAT(lf.quantidade,'x ',p.nome,' val.:',lf.valor_unitario,' desc.:', COALESCE(lf.desconto, 0))) as item, date_format(cf.data_finalizacao, '%d-%m-%Y') as fechamento,  c.nome, c.sobrenome
        FROM comandafatura AS cf
        INNER JOIN linhafatura AS lf ON cf.id = lf.id_comanda_fatura
        INNER JOIN produto AS p ON lf.id_produto = p.id
        LEFT JOIN cliente as c ON cf.id_cliente = c.id
        WHERE  cf.data_registro BETWEEN :dtInicial AND :dtInicial
        GROUP BY cf.id ORDER BY abertura ASC");
        // $stmt->bindParam(':idCliente', $cliente['idCliente'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}