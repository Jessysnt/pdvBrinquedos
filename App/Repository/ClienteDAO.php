<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Cliente;

use PDO;

class ClienteDAO extends Conexao
{
    public function adicionarCliente($dados)
    {
        $usuario = $_SESSION['usuario']->getId();
        $stmt = static::getConexao()->prepare("INSERT INTO cliente (id_usuario, nome, sobrenome, telefone, email, cpf) VALUES (:usuario, :nome, :sobrenome, :telefone, :email, :cpf)");
        $stmt->bindParam(':usuario', $usuario , PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $dados['sobrenome'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $dados['telefone'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Dados passado para a tela cliente-venda
     */
    public function exibirCliente($idCliente)
    {
        $stmt = static::getConexao()->prepare("SELECT c.id, c.cpf, c.nome, c.sobrenome, c.telefone, COUNT(DISTINCT cf.id) as totalVendas, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END) AS totalLiquido, SUM(CASE WHEN cf.data_finalizacao IS NOT NULL THEN CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ELSE 0 END)/COUNT(DISTINCT cf.id) as ticketMedio FROM cliente AS c
        LEFT JOIN comandafatura AS cf ON cf.id_cliente = c.id
        WHERE c.id = :id AND c.status=1 AND cf.comanda_aberta=0");
        $stmt->bindParam(':id', $idCliente, PDO::PARAM_INT);
        $stmt->execute(); 
        return $stmt->fetchObject('\App\Entity\Cliente');
    }

    /**
     * Manda os dados para o select da comanda
     */
    public function pesquisarClientes($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT id, cpf AS 'text', nome, sobrenome FROM cliente WHERE cpf LIKE :cpf");
        $stmt->bindValue(':cpf', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exibe o cliente da comanda
     */
    public function pesquisarClienteComanda($cliente)
    {
        $stmt = static::getConexao()->prepare("SELECT id, cpf, nome, sobrenome FROM cliente WHERE id = :id AND status=1");
        $stmt->bindParam(':id', $cliente , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tabClientes($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        $stmt = static::getConexao()->prepare("SELECT * FROM cliente WHERE nome LIKE :busca AND status=1 LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function qntTotalClientes($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(id) AS total FROM cliente WHERE nome LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function inativarCliente($cliente)
    {
        $stmt = static::getConexao()->prepare("UPDATE cliente SET status=0 WHERE id = :id");
        $stmt->bindParam(':id', $cliente, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obterCliente($cliente)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM cliente WHERE id=:id");
        $stmt->bindParam(':id', $cliente['idcliente'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarCliente($cliente)
    {
        $stmt=static::getConexao()->prepare("UPDATE cliente SET nome=:nome, sobrenome=:sobrenome, email=:email, telefone=:telefone WHERE id=:id");
        $stmt->bindParam(':id', $cliente['idclienteU'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $cliente['nomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':sobrenome', $cliente['sobrenomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $cliente['emailU'], PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $cliente['telefoneU'], PDO::PARAM_STR);
        // $stmt->bindParam(':cpf', $cliente['cpfU'], PDO::PARAM_STR);         
        return $stmt->execute();
	}

    /**
     * Cliente na tela de relatorio
     */
    public function vendaClienteData($cliente)
    {
        // die(var_dump($cliente));
        // COUNT(DISTINCT v.id) as totalVendas, SUM(v.total) as totalLiquido, SUM(v.total) / COUNT(DISTINCT v.id) as ticketMedio") 
        $cliente['dtInicial'] = $cliente['dtInicial'].' 00:00:00';
        $cliente['dtFinal'] = $cliente['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT COUNT(DISTINCT id) as totalVendas, SUM(CASE WHEN data_finalizacao IS NOT NULL THEN CASE WHEN valor_total2 IS NOT NULL THEN (valor_total1 + valor_total2) ELSE valor_total1 END ELSE 0 END) AS totalLiquido, SUM(CASE WHEN data_finalizacao IS NOT NULL THEN CASE WHEN valor_total2 IS NOT NULL THEN (valor_total1 + valor_total2) ELSE valor_total1 END ELSE 0 END)/COUNT(DISTINCT id) as ticketMedio FROM comandafatura WHERE data_finalizacao BETWEEN :dtInicial AND :dtFinal AND id_cliente=:idCliente");
        $stmt->bindParam(':idCliente', $cliente['idCliente'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $cliente['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $cliente['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function vendaCliente($cliente)
    {
        $cliente['dtInicial'] = $cliente['dtInicial'].' 00:00:00';
        $cliente['dtFinal'] = $cliente['dtFinal'].' 23:59:59';
        $stmt = static::getConexao()->prepare("SELECT cf.id, date_format(cf.data_finalizacao, '%d-%m-%Y') as data, (CASE WHEN cf.valor_total2 IS NOT NULL THEN (cf.valor_total1 + cf.valor_total2) ELSE cf.valor_total1 END ) AS total, GROUP_CONCAT(CONCAT(lf.quantidade,'x ',p.nome,' val.:',lf.valor_unitario,' desc.:', COALESCE(lf.desconto, 0))) as item
        FROM comandafatura AS cf
        INNER JOIN linhafatura AS lf ON cf.id = lf.id_comanda_fatura
        INNER JOIN produto AS p ON lf.id_produto = p.id
        WHERE cf.id_cliente =:idCliente AND cf.data_finalizacao BETWEEN :dtInicial AND :dtFinal
        GROUP BY cf.id ORDER BY data ASC");
        $stmt->bindParam(':idCliente', $cliente['idCliente'], PDO::PARAM_INT);
        $stmt->bindParam(':dtInicial', $cliente['dtInicial'], PDO::PARAM_STR);
        $stmt->bindParam(':dtFinal', $cliente['dtFinal'], PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
