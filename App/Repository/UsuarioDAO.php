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


    public function atualizarUsuario($dados)
    {   
        $stmt=static::getConexao()->prepare("UPDATE usuario SET nome=:nome, sobrenome=:sobrenome, email=:email, cargo=:cargo, status=:statusU WHERE id=:id");
        $stmt->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['emailU'], PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $dados['cargoU'], PDO::PARAM_INT);   
        $stmt->bindParam(':statusU', $dados['statusU'], PDO::PARAM_INT);        
        return $stmt->execute();
	}

    public function inativarUsuario($dados)
    {
		$stmt=static::getConexao()->prepare("UPDATE usuario SET status=0 WHERE id=:id");
        $stmt->bindParam(':id', $dados['idusuario'], PDO::PARAM_INT);
		return $stmt->execute();
	}

    public function tabUsuario($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE nome LIKE :busca ORDER BY status desc LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Usuario');
    }

    public function qntTotalUsuarios($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM usuario WHERE nome LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Dados passado para a tela usuario-venda
     */
    public function exibirUsuario($idUsuario)
    {
        $stmt = static::getConexao()->prepare("SELECT id, nome, sobrenome, cargo FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute(); 
        return $stmt->fetchObject('\App\Entity\Usuario');
    }

    public function obterUsuario($dados)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $dados['idusuario'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function vendaUsuarioData($usuario)
    {
        // die(var_dump($usuario));
        $stmt = static::getConexao()->prepare("SELECT numero, valor_total1, valor_total2 AS Total  FROM comandafatura WHERE data_finalizacao < :dtInicial AND data_finalizacao > :dtFinal AND id_vendedor=:idVendedor");
        $stmt->bindParam(':idVendedor', $usuario['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $usuario['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $usuario['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}