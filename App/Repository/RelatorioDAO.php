<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class RelatorioDAO extends Conexao
{
    public function maisVendidos($datas)
    {
        $datas['dtInicial'] = $datas['dtInicial'].' 00:00:00';
        $datas['dtFinal'] = $datas['dtFinal'].' 23:59:59';
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
        $stmt = static::getConexao()->prepare("SELECT cf.id, cf.numero, cf.comanda_aberta, date_format(cf.data_registro, '%d-%m-%Y') as abertura, (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) WHEN cf.valor_total1 IS NULL THEN SUM(lf.quantidade * lf.valor_unitario) ELSE cf.valor_total1 END ) AS total, GROUP_CONCAT(CONCAT(lf.quantidade,'x ',p.nome,' val.:',lf.valor_unitario,' desc.:', COALESCE(lf.desconto, 0))) as item, date_format(cf.data_finalizacao, '%d-%m-%Y') as fechamento,  CONCAT(c.nome, ' ',c.sobrenome) as cliente, CONCAT(u.nome,' ',u.sobrenome) as vendedor
        FROM comandafatura AS cf
        INNER JOIN linhafatura AS lf ON cf.id = lf.id_comanda_fatura
        INNER JOIN produto AS p ON lf.id_produto = p.id
        LEFT JOIN cliente as c ON cf.id_cliente = c.id
        LEFT JOIN usuario as u ON cf.id_vendedor = u.id
        WHERE  cf.data_registro BETWEEN :dtInicial AND :dtFinal
        GROUP BY cf.id ORDER BY abertura ASC");
        // $stmt->bindParam(':idCliente', $cliente['idCliente'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Paginaçao comanda
     */
    public function mostrarComanda($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM lancamento  WHERE descricao LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Paginaçao comanda
     */
    public function qntTotalComanda($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM lancamento WHERE descricao LIKE :busca LIMIT 1 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function vendasPeriodoColaboradores($datas)
    {
        $datas['dtInicial'] = $datas['dtInicial'].' 00:00:00';
        $datas['dtFinal'] = $datas['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT u.id, CONCAT(u.nome,' ',u.sobrenome) AS nome, COUNT(DISTINCT cf.id) as totalVendas, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS totalLiquido, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END)/COUNT(DISTINCT cf.id) AS ticketMedio
        FROM usuario AS u
        INNER JOIN comandafatura AS cf ON cf.id_vendedor=u.id
        WHERE u.status=1 AND cf.data_finalizacao BETWEEN :dtInicial AND :dtFinal
        GROUP BY u.id ORDER BY totalLiquido DESC");
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Relatorio visualizaçao de lançamentos e vendas
     */
    public function lancamentoVenda($datas)
    {
        $datas['dtInicial'] = $datas['dtInicial'].' 00:00:00';
        $datas['dtFinal'] = $datas['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT date_format(a.dia,'%Y-%m') AS mes, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS venda, SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END) as entrada, SUM(CASE WHEN l.valor < 0 THEN ABS(l.valor) ELSE 0 END) as saida, (SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) + SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END)) - (SUM(CASE WHEN l.valor < 0 THEN ABS(l.valor) ELSE 0 END)) AS saldo FROM (SELECT last_day(:dtFinal) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c ) AS a
        LEFT JOIN comandafatura as cf ON a.dia = date_format(cf.data_finalizacao,'%Y-%m-%d')
        LEFT JOIN lancamento as l ON l.data =  date_format(cf.data_finalizacao,'%Y-%m-%d')
        WHERE a.dia between :dtInicial AND :dtFinal
        GROUP BY mes ORDER BY mes");
        $stmt->bindParam(':dtInicial', $datas['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $datas['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}