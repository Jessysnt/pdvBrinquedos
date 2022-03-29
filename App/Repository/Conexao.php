<?php

namespace App\Repository;

use PDO;
use App\Config;

abstract class Conexao{
    
    public static function getConexao(){
        try {
            $conexao = new PDO('mysql:host='.Config::HOST.';dbname='.Config::NAME, Config::USER, Config::PASSWORD);
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexao;
    
        } catch (\PDOException $e) {
            $e->getMessage();
        }

    }
}

