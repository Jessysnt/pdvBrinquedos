<?php

namespace App\DAO;

use PDO;

class Conexao{

    /**
     * @var string
     */
    const HOST = "localhost";

    /**
     * @var string
     */
    const USER = "root";

    /**
     * @var string
     */
    const NAME = "lojab";

    /**
     * @var string
     */
    const PASSWORD = "";
    
    /**
     * @var PDO
     */
    private $conexao;
    
    public function setConexao(){
        try {
            $this->conexao = new PDO("mysql:host='.self::HOST.';dbname='.self::NAME.'", self::USER, self::PASSWORD);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexao;
    
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

