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

    /**
     * Pesquisa categoria para trazer no cadastro de Produto
     */
    public function pesquisarCategorias($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT id, categoria AS 'text' FROM categoria WHERE categoria LIKE :categoria");
        $stmt->bindValue(':categoria', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tabCategoria($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        // die(var_dump($offset));
        $stmt = static::getConexao()->prepare("SELECT * FROM categoria WHERE categoria LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function qntTotalCategoria($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM categoria WHERE categoria LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');

        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}