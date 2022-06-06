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

    public function vendasAno()
    {
        $stmt = static::getConexao()->prepare("SELECT m.mes,m.entradas,ABS(m.saidas) as saidas, m.saldo, 
CASE WHEN SUBSTR(m.mes,-2,2) = '01' THEN @csum := @csum + (SELECT CASE WHEN COUNT(*) > 0 THEN SUM(CASE WHEN l.valor THEN l.valor ELSE 0 END) ELSE 0 END as valor FROM lancamento as l ) + m.saldo ELSE @csum := @csum + m.saldo END as saldo_acumulado 
FROM(SELECT date_format(a.dia,'%Y-%m') AS mes
SUM(CASE WHEN l.valor > 0 THEN l.valor ELSE 0 END) as entradas, 
SUM(CASE WHEN l.valor < 0 THEN ABS(l.valor) ELSE 0 END) as saidas, 
SUM(CASE WHEN l.valor THEN l.valor ELSE 0 END) as saldo
FROM (SELECT last_day('2022-12-01') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c ) AS a
LEFT JOIN lancamento as l ON a.dia = date_format(l.data,'%Y-%m-%d')
GROUP BY mes ORDER BY mes) AS m JOIN (SELECT @csum := 0)");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}