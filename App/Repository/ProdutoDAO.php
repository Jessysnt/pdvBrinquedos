<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Produto;
use PDO;

class ProdutoDAO extends Conexao
{
    /**
     * Adiciona imagem no banco e tras o id adicionar na tabela produto
     */
    public function addImagem($dados)
    {
        $bd = static::getConexao();
        $stmt=$bd->prepare("INSERT INTO imagem (nome, url) VALUES (:nome, :url)");
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':url', $dados['url'], PDO::PARAM_STR);
        $stmt->execute();
        $resp = $bd->lastInsertId();
        return $resp;
	}

    public function addProduto($dados)
    {
        $stmt=static::getConexao()->prepare("INSERT INTO produto (id_imagem, id_usuario, id_categoria, nome, codigo, descricao) VALUES (:idImagem, :idUsuario, :idCategoria, :nome, :codigo, :descricao)");
        $stmt->bindParam(':idImagem', $dados['idImagem'], PDO::PARAM_INT);
        $stmt->bindParam(':idUsuario', $dados['idUsuario'], PDO::PARAM_INT);
        $stmt->bindParam(':idCategoria', $dados['idCategoria'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $dados['codigo'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function exibirProdutos()
    {
        $stmt = static::getConexao()->query("SELECT * FROM produto");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Pesquisa produto para trazer no cadastro de ProdutoVenda 
     */
    public function pesquisarProdutos($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT id, nome AS 'text' FROM produto WHERE nome LIKE :nome");
        $stmt->bindValue(':nome', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tras os produtos para as paginas tabela
     */
    public function mostrarProduto($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        
        $stmt = static::getConexao()->prepare("SELECT pro.id, pro.nome, pro.codigo, pro.descricao, img.url, cat.categoria FROM produto AS pro INNER JOIN imagem AS img ON pro.id_imagem=img.id INNER JOIN categoria AS cat ON pro.id_categoria=cat.id WHERE pro.nome LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica quando produtos ha cadastrado para exibir a paginaçao
     */
    public function qntTotalProduto($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(pro.id) AS total FROM produto as pro INNER JOIN imagem as img ON pro.id_imagem=img.id INNER JOIN categoria AS cat ON pro.id_categoria=cat.id WHERE pro.nome LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obterProduto($produto)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM produto WHERE id=:id");
        $stmt->bindParam(':id', $produto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarProduto($produto)
    {
        $stmt=static::getConexao()->prepare("UPDATE produto SET nome=:nome, codigo=:codigo, descricao=:descricao, id_categoria=:idCategoria WHERE id=:id");
        $stmt->bindParam(':id', $produto['idProduto'], PDO::PARAM_INT);
        $stmt->bindParam(':nome', $produto['nomeU'], PDO::PARAM_STR);
        $stmt->bindParam(':codigo', $produto['codigoU'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $produto['descricaoU'], PDO::PARAM_STR);
        $stmt->bindParam(':idCategoria', $produto['categoriaU'], PDO::PARAM_INT);        
        return $stmt->execute();
	}

    public function excluirProduto($produto)
    {
        $stmt = static::getConexao()->prepare("SELECT id FROM produtovenda WHERE id_produto=:idProduto");
        $stmt->bindParam(':idProduto', $produto, PDO::PARAM_INT);
        $stmt->execute();
        $respPV = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($respPV == false){
            $idimagem=self::obterIdImg($produto);
            $stmt = static::getConexao()->prepare("DELETE FROM imagem WHERE id=:idimagem");
            $stmt->bindParam(':idimagem', $idimagem['id_imagem'], PDO::PARAM_INT);
            $respExcluirImg = $stmt->execute();
            if($respExcluirImg == true){
                $stmt = static::getConexao()->prepare("DELETE FROM produto WHERE id=:idProduto");
                $stmt->bindParam(':idProduto', $produto, PDO::PARAM_INT);
                return $stmt->execute();
            }
        }else{
            return false;
        }
    }

    /**
     * Tras o id da Imagem.. pq apos excluir o produto tem q exclir a imagem associada
     */
    public function obterIdImg($produto)
    {
        $stmt = static::getConexao()->prepare("SELECT id_imagem FROM produto WHERE id='$produto'");
        $stmt->bindParam(':idProduto', $produto, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Pesquisa produto para trazer na comanda 
     */
    public function pesquisarProdutoEstoque($nomeparcial)
    {
        $stmt = static::getConexao()->prepare("SELECT pro.id, pro.nome AS 'text' FROM produto AS pro INNER JOIN estoque AS es ON pro.id = es.id_produto WHERE nome LIKE :nome");
        $stmt->bindValue(':nome', '%'.$nomeparcial.'%');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica se a categoria esta cadastrada no produto
     */
    public function categoriaProduto($categoria)
    {
        $stmt = static::getConexao()->prepare("SELECT * FROM produto WHERE id_categoria=:idcategoria");
        $stmt->bindParam(':idcategoria', $categoria, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}