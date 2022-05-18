<?php

namespace App\Repository;

use App\Repository\Conexao;
use PDO;

class PainelDAO extends Conexao
{
    public function vendasMesAno()
    {
        $stmt = static::getConexao()->query("SELECT data_finalizacao FROM comandafatura WHERE data_finalizacao IS NOT null");
        // $stmt->bindValue(':busca', '%'.$busca.'%');
        // $stmt->execute();
        // $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // die(var_dump($result));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}