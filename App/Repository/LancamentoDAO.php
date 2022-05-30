<?php

namespace App\Repository;

use PDO;

class LancamentoDAO extends Conexao
{
    public function tabUsuario($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM lancamento WHERE descricao LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Usuario');
    }

    public function qntTotalUsuarios($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM lancamento WHERE descricao LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarLancamento($dados)
    {
        $stmt = static::getConexao()->prepare("INSERT INTO lancamento (descricao, data, valor) VALUES (:descricao, :data, :valor)");
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':data', $dados['data'], PDO::PARAM_STR);
        $stmt->bindParam(':valor', $dados['valor'], PDO::PARAM_STR);
        return $stmt->execute();
    }
}