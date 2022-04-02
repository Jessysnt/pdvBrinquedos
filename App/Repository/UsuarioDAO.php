<?php

namespace App\Repository;

use App\Entity\Usuario;
use PDO;
use App\Repository\Conexao;
use Dompdf\Image\Cache;

class UsuarioDAO extends Conexao
{

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

    public function registroUsuario($dados)
    {
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

        $stmt=static::getConexao()->prepare("UPDATE usuario SET nome=:nome, sobrenome=:sobrenome, email=:email, cargo=:cargo WHERE id=:id");
        $stmt->bindParam(':id', $dados['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['emailU'], PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $dados['cargoU'], PDO::PARAM_INT);
                        
        return $stmt->execute();
	}

    public function deletarUsuario($dados){
		$stmt=static::getConexao()->prepare("DELETE FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $dados['idusuario'], PDO::PARAM_INT);

		return $stmt->execute();
	}

    public function exibirUsuario(){
        $stmt = static::getConexao()->query("SELECT * FROM usuario");
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Usuario');
    }

    public function obterUsuario($dados){
        $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $dados['idusuario'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}