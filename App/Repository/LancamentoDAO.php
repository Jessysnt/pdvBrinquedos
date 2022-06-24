<?php

namespace App\Repository;

use PDO;

class LancamentoDAO extends Conexao
{
    public function tabLancamento($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM lancamento WHERE descricao LIKE :busca order by data desc LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function qntTotalLancamento($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM lancamento WHERE descricao LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarLancamento($dados)
    {
        $stmt = static::getConexao()->prepare("INSERT INTO lancamento (descricao, data, valor, id_usuario) VALUES (:descricao, :data, :valor, :usuario)");
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':data', $dados['data'], PDO::PARAM_STR);
        $stmt->bindParam(':valor', $dados['valor'], PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function somaEntreDatas($datas)
    {
        $stmt = static::getConexao()->prepare("SELECT a.dia AS dia, sum(valor) AS Total FROM (SELECT last_day(:dtInicial) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY AS dia from (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b cross join (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c) AS a 
        LEFT JOIN lancamento AS la ON a.dia = date_format(la.data, '%Y-%m-%d') 
        WHERE a.dia between :dtInicial AND last_day(:dtInicial) 
        GROUP BY a.dia
        ORDER BY a.dia");
        $stmt->bindParam(':dtInicial', $dtInicial, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}