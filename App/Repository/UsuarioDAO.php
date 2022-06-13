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
        $senha = sha1($dados['senha']);
        $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE email=:email AND senha=:senha");
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject('\App\Entity\Usuario');
    }

    public function registroUsuario($dados)
    {
        $senha = sha1($dados['senha']);
        $stmt = static::getConexao()->prepare("INSERT INTO usuario (nome, sobrenome, cpf, email, senha, cargo, acesso) VALUES (:nome, :sobrenome, :cpf, :email, :senha, :cargo, :acesso)");
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':cargo', $dados['cargo'], PDO::PARAM_STR);
        $stmt->bindValue(':acesso', $dados['acessos']);
        return $stmt->execute();
    }

    public function verificaAdm(){
        $stmt = static::getConexao()->query("SELECT * FROM usuario WHERE cargo='Administrador'");
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
        $stmt = static::getConexao()->prepare("SELECT u.id, u.nome, u.sobrenome, u.cargo, COUNT(DISTINCT cf.id) AS totalVendas, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS totalLiquido, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END)/COUNT(DISTINCT cf.id) AS ticketMedio
        FROM usuario AS u
        LEFT JOIN comandafatura AS cf ON cf.id_vendedor = u.id
        WHERE u.id=:id AND cf.data_finalizacao IS NOT NULL");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute(); 
        return $stmt->fetchObject('\App\Entity\Usuario');
    }

    public function obterUsuario($idUsuario)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM usuario WHERE id=:id");
        $stmt->bindParam(':id', $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject('\App\Entity\Usuario');
    }

    /**
     * Usuario na tela de relatorio
     */
    public function vendaUsuarioData($usuario)
    {
        $usuario['dtInicial'] = $usuario['dtInicial'].' 00:00:00';
        $usuario['dtFinal'] = $usuario['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT COUNT(DISTINCT id) as totalVendas, SUM(CASE WHEN data_finalizacao IS NOT NULL THEN CASE WHEN valor_total2 IS NOT NULL THEN (valor_total1 + valor_total2) ELSE valor_total1 END ELSE 0 END) AS totalLiquido, SUM(CASE WHEN data_finalizacao IS NOT NULL THEN CASE WHEN valor_total2 IS NOT NULL THEN (valor_total1 + valor_total2) ELSE valor_total1 END ELSE 0 END)/COUNT(DISTINCT id) AS ticketMedio FROM comandafatura WHERE data_finalizacao BETWEEN :dtInicial AND :dtFinal AND id_vendedor=:idVendedor");
        $stmt->bindParam(':idVendedor', $usuario['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $usuario['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $usuario['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function vendaUsuarioPeriodo($usuario)
    {
        $usuario['dtInicial'] = $usuario['dtInicial'].' 00:00:00';
        $usuario['dtFinal'] = $usuario['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT cf.id, date_format(cf.data_finalizacao, '%d-%m-%Y') as data, (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ) AS total, c.id, c.nome, c.sobrenome FROM comandafatura AS cf
        LEFT JOIN cliente AS c ON cf.id_cliente = c.id
        WHERE cf.id_vendedor = :idVendedor AND cf.data_finalizacao BETWEEN :dtInicial AND :dtFinal ORDER BY data ASC");
        $stmt->bindParam(':idVendedor', $usuario['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $usuario['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $usuario['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificaPermissaoDesconto($dados)
    {
        $senha = sha1($dados['senha']);
        $stmt = static::getConexao()->prepare("SELECT id, cargo FROM usuario WHERE cpf=:cpf AND senha=:senha AND cargo in ('Administrador', 'Gerente', 'Supervisor')");
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}