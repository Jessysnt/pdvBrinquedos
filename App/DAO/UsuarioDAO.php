<?php

namespace App\DAO;

use PDO;

class UsuarioDAO extends Conexao{

    public function login($dados){
        $stmt = $this->setConexao()->query("SELECT * FROM usuarios WHERE email=:email AND senha=:senha");
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stmt->fetchAll(PDO::FETCH_CLASS,'\App\Entity\Usuario');
    }

    public function registroUsuario($dados){
        $fields = array_keys($dados);

        
    }
}