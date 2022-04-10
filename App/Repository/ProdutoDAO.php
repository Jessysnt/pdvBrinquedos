<?php

namespace App\Repository;

use App\Repository\Conexao;
use App\Entity\Produto;
use PDO;

class ProdutoDAO extends Conexao
{
    public function addImagem($dados){

        try{
            $bd = static::getConexao();
            $stmt=$bd->prepare("INSERT INTO imagem (nome, url) VALUES (:nome, :url)");

            $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':url', $dados['url'], PDO::PARAM_STR);

            $stmt->execute();
            $resp = $bd->lastInsertId();

            return $resp;
            
        }catch(\PDOException $e){
            return $e->getMessage();
        }
		
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

    public function mostrarProduto($busca, $pagina, $itensPag)
    {
        $offset = $itensPag*($pagina-1);
        // die(var_dump($offset));
        $stmt = static::getConexao()->prepare("SELECT pro.id, pro.nome, pro.codigo, pro.descricao, img.url, cat.categoria FROM produto AS pro INNER JOIN imagem AS img ON pro.id_imagem=img.id INNER JOIN categoria AS cat ON pro.id_categoria=cat.id WHERE pro.nome LIKE :busca LIMIT :itensPag OFFSET :offset");
        $stmt->bindValue(':busca', '%'.$busca.'%');
        $stmt->bindParam(':itensPag', $itensPag, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function qntTotalProduto($busca)
    {
        $stmt = static::getConexao()->prepare("SELECT count(pro.id) AS total FROM produto as pro INNER JOIN imagem as img ON pro.id_imagem=img.id INNER JOIN categoria AS cat ON pro.id_categoria=cat.id WHERE pro.nome LIKE :busca LIMIT 10 ");
        $stmt->bindValue(':busca', '%'.$busca.'%');

        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
 
    // public function obterProduto($idproduto){
    //     $stmt=static::getConexao()->prepare("SELECT id_produto, nome, descricao  FROM produtos WHERE id_produto='$idproduto'");

    //     $result=mysqli_query($conexao, $sql);

    //     $mostrar=mysqli_fetch_row($result);

    //     $dados=array(
    //         "id_produto" => $mostrar[0],
    //         "nome" => $mostrar[1],
    //         "descricao" => $mostrar[2]
    //     );

    //     return $dados;
    // }

    // public function atualizarProduto($dados){
    //     $stmt=static::getConexao()->prepare("UPDATE produtos set  nome= '$dados[1]', descricao= '$dados[2]' WHERE id_produto='$dados[0]'");
    // }

    // public function deletarProduto($idproduto){
    //     $c= new conectar();
    //     $conexao=$c->conexao();

    //     $idimagem=self::obterIdImg($idproduto);

    //     $sql="DELETE from produtos 
    //             where id_produto='$idproduto'";
    //     $result=mysqli_query($conexao,$sql);

    //     if($result){
    //         $url=self::obterUrlImagem($idimagem);

    //         $sql="DELETE from imagens 
    //                 where id_imagem='$idimagem'";
    //         $result=mysqli_query($conexao,$sql);
    //             if($result){
    //                 if(unlink($url)){
    //                     return 1;
    //                 }
    //             }
    //     }
    // }

    // public function obterIdImg($idProduto){
    //     $stmt=static::getConexao()->prepare("SELECT id_imagem FROM produtos WHERE id_produto='$idProduto'");
    //     $result=mysqli_query($conexao,$sql);

    //     return mysqli_fetch_row($result)[0];
    // }

    // public function obterUrlImagem($idImg){
    //     $stmt=static::getConexao()->prepare("SELECT url FROM imagens WHERE id_imagem='$idImg'");

    //     $result=mysqli_query($conexao,$sql);

    //     return mysqli_fetch_row($result)[0];
    // }

}