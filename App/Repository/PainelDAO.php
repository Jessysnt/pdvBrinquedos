<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class PainelDAO extends Conexao
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
}