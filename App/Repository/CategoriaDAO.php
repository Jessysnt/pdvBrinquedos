<?php

namespace App\Repository;

use PDO;

class CategoriaDAO extends Conexao
{
    public function cadastrarCategoria($dados)
    {
        $idUsuario=$_SESSION['usuario']->getId();

        $stmt = static::getConexao()->prepare("INSERT INTO categoria (id_usuario, categoria, descricao) VALUES (:idUsuario, :categoria, :descricao)");
        
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $dados['categoria'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function tabCategoria()
    {
        $stmt = static::getConexao()->query("SELECT * FROM categoria");
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Categoria');
    }
}