<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class DashboardDAO extends Conexao
{
    public function vendasMesAno()
    {
        $stmt = static::getConexao()->query("SELECT DATE_FORMAT(data_finalizacao, '%Y') as ANO FROM comandafatura WHERE data_finalizacao is NOT null GROUP BY ANO");
        // $stmt->bindValue(':busca', '%'.$busca.'%');
        // $stmt->execute();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // die(var_dump($result));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function datasMesAno($dtInicial)
    {
        $stmt = static::getConexao()->prepare("SELECT a.dia AS dia, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS Total FROM (SELECT last_day(:dtInicial) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c) AS a 
        LEFT JOIN comandafatura AS cf ON a.dia = date_format(cf.data_finalizacao, '%Y-%m-%d') 
        WHERE a.dia between :dtInicial AND last_day(:dtInicial) 
        GROUP BY a.dia
        ORDER BY a.dia");
        $stmt->bindParam(':dtInicial', $dtInicial, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function vendasAno($dtInicial)
    // {
    //     $stmt = static::getConexao()->prepare("SELECT date_format(a.dia,'%Y-%m') AS mes, SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END) as entradas, SUM(CASE WHEN l.valor < 0 THEN ABS(l.valor) ELSE 0 END) as saidas, SUM(CASE WHEN l.valor THEN l.valor ELSE 0 END) as saldo FROM (SELECT last_day('2022-12-01') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c ) AS a
    //     LEFT JOIN lancamento as l ON a.dia = date_format(l.data,'%Y-%m-%d')
    //     WHERE date_format(l.data,'%Y') = :dtInicial
    //     GROUP BY mes ORDER BY mes");
    //     $stmt->bindParam(':dtInicial', $dtInicial, PDO::PARAM_STR);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    /**
     * Entradas(com vendas) e saidas buscada pelo ano.. grafico dashboard
     */
    public function vendasAno($datas)
    {
        $stmt = static::getConexao()->prepare("SELECT date_format(t.dia,'%Y-%m') AS mes, SUM(t.saida) AS saida, SUM(t.entrada + t.venda) AS entrada
        FROM(SELECT vd.*,
        SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END) as entrada,
        SUM(CASE WHEN l.valor < 0 THEN ABS(l.valor) ELSE 0 END) as saida  
        FROM(SELECT a.dia as dia , 
        SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS venda 
        FROM (SELECT last_day(:data) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c ) AS a
        LEFT JOIN comandafatura as cf ON a.dia = date_format(cf.data_finalizacao,'%Y-%m-%d')
        GROUP BY a.dia ORDER BY a.dia desc) as vd
        LEFT JOIN lancamento as l ON vd.dia = date_format(l.data, '%Y-%m-%d')
        GROUP BY vd.dia ORDER BY vd.dia desc) as t
        WHERE date_format(t.dia,'%Y') = :ano
        GROUP BY mes ORDER BY mes");
        $stmt->bindParam(':ano', $datas['ano'], PDO::PARAM_STR);
        $stmt->bindParam(':data', $datas['data'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}