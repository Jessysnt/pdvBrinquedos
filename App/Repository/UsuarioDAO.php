<?php

namespace App\Repository;

use App\Entity\Usuario;
use PDO;
use App\Repository\Conexao;
use Dompdf\Image\Cache;

class UsuarioDAO extends Conexao{

    public function login($dados)
    {
        try{
            $senha = sha1($dados['senha']);
            $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE email=:email AND senha=:senha");
            $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            // return $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->execute();
            return $stmt->fetchObject('\App\Entity\Usuario');
        }catch (\PDOException $e){
            return $e->getMessage();
        }
        
    }

    public function registroUsuario($dados){
        $senha = sha1($dados['senha']);

        $stmt = static::getConexao()->prepare("INSERT INTO usuario (nome, sobrenome, email, senha, cargo) VALUES (:nome, :sobrenome, :email, :senha, :cargo)");
        
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $dados['cargo'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function verificaAdm(){
        $stmt = static::getConexao()->query("SELECT * FROM usuario WHERE cargo=1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function atualizarUsuario($dados){

		$stmt=static::getConexao()->prepare("UPDATE usuario SET nome=:nome, user=:user, email=:email, cargo=:cargo WHERE id=:id");
        $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $dados['cargo'], PDO::PARAM_INT);
					
		return $stmt->execute();
	}

    public function deletarUsuario($idusuario){

		$stmt=static::getConexao()->prepare("DELETE FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $idusuario['id'], PDO::PARAM_INT);

		return $stmt->execute();
	}

    
}