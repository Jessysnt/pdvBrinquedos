<?php

namespace App\Controller;

use App\Repository\ClienteDAO;
use App\Repository\EstoqueDAO;
use App\Repository\PdvDAO;
use App\Repository\UsuarioDAO;
use Core\View;
use DateTimeZone;
use Dompdf\Dompdf;
use PDO;

class PdvController
{
    public function telaInicial()
    {
        View::renderTemplate('/pdv/pdv.html');
    }

    public function obterDadosNumero()
    {
        $obPdvDAO = new PdvDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d");
            $comanda=array(
                'numero'=> $_POST['numero'],
                'dtInicial'=> $datetime,
                'dtFinal'=> $datetime
            );
            $respNumero=$obPdvDAO->verEstaAberta($comanda);
            if($respNumero > 0){
                $obProdutoLinha = intval($respNumero['id']);
                $respProdutoLinha = $obPdvDAO->verProdutoLinha($obProdutoLinha);
                $resp = $respNumero;
                $resp['linhas'] = $respProdutoLinha;
                View::jsonResponse($resp);
            }else{
                View::jsonResponse(false);
            }
        }
    }

    public function gravarComanda()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obPdvDAO = new PdvDAO;
            $obEstoqueDAO = new EstoqueDAO;
            
            $id_usuario=$_SESSION['usuario']->getId();
            date_default_timezone_set("America/Sao_Paulo");
            $datetime = date("Y-m-d H:i:s");

            $comandaFatura=array(
                'id_caixa'=> $id_usuario,
                'id' => intval($_POST['id']),
                'numero' => $_POST['numero'],
                'cliente' => intval($_POST['cliente']),
                'formaPgUm' => intval($_POST['pg_forma1']),
                'valorTotalUm' => $_POST['valor_total1'],
                'formaPgDois' => intval($_POST['pg_forma2']),
                'valorTotalDois' => $_POST['valor_total2'],
                'vzsCartao1' => intval($_POST['vzs_cartao1']),
                'vzsCartao2' => intval($_POST['vzs_cartao2']),
                'desconto' => $_POST['desconto'],
                'dataFinalizacao' => $datetime
            );
            
            if($_POST['numero'] == ""){
                unset($comandaFatura['numero']);
            }
            if($_POST['cliente'] == ""){
                unset($comandaFatura['cliente']);
            }
            if($_POST['pg_forma2'] == ""){
                unset($comandaFatura['formaPgDois']);
                unset($comandaFatura['valorTotalDois']);
            }
            if($_POST['vzs_cartao1'] == ""){
                unset($comandaFatura['vzsCartao1']);
            }
            if($_POST['vzs_cartao2'] == ""){
                unset($comandaFatura['vzsCartao2']);
            }
            if($_POST['desconto'] == 'NaN'){
                unset($comandaFatura['desconto']);
            }
            if($_POST['id'] == ""){
                unset($comandaFatura['id']);
            }
            
            if($_POST['id'] == ""){
                $respComandaFatura=$obPdvDAO->gravarComandaFaturaSemNumero($comandaFatura);
            }else{
                $respComandaFatura=$obPdvDAO->gravarComandaFatura($comandaFatura);
            }

            $deleteLinhaFatura=$obPdvDAO->deletarLinhaFatura($respComandaFatura);
            
            if($respComandaFatura > 0){
                foreach($_POST['linhas'] as $row) {
                    $linhaFatura=array(
                        'id_comanda_fatura'=>$respComandaFatura,
                        'id_produto'=>$row['id_produto'],
                        'quantidade'=>$row['quantidade'],
                        'valor_unitario'=>$row['valor_unitario'],
                    );
                    $resp = $obPdvDAO->gravarLinhaFatura($linhaFatura);
                    
                    if($resp){
                        $obEstoque = $obEstoqueDAO->retornaProdEst($row['id_produto']);

                        if($obEstoque){
                            $obEstoque->diminuiQuantidade($row['quantidade']);
                            $dados=array(
                                'idEstoque'=>$obEstoque->getId(),
                                'quantotal'=> $obEstoque->getQuantotal()
                            ); 
                            $obEstoqueDAO->baixaEstoque($dados);
                        }else{
                            View::jsonResponse(['resp'=>false]);
                        }

                    }else{
                        View::jsonResponse(['resp'=>false]);
                    }
                }
                View::jsonResponse(['resp'=>true]);
            }
        }
    }

    /**
     * Apaga produto a tabela temporaria
     */
    public function apagarProdutoComanda()
    {
        $obPdvDAO = new PdvDAO();

        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            parse_str(file_get_contents("php://input"), $post);
            $respDeletarProduto = $obPdvDAO->deletarProdutoComanda($post['id_comanda_fatura']);
            View::jsonResponse($respDeletarProduto);
        }
    }

    /**
     * Comanda aberta, tras o cliente para a tela
     */
    public function pesqClienteComanda()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obClienteDAO = new ClienteDAO;
            $respCliente = $obClienteDAO->pesquisarClienteComanda($_POST['cliente']);
            View::jsonResponse($respCliente);
        }
    }

    /**
     * Permissao de desconto
     */
    public function verificaPermissaoDesconto()
    {
        $obUsuario = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obUsuario->verificaPermissaoDesconto($_POST);
            View::jsonResponse($resp);
        }
    }

    public function impressaoVenda()
    {
        $obPdvDAO = new PdvDAO();
        if($_GET['venda']){
            $respDAOId = $obPdvDAO->tabelaComprovanteVendaId(intval($_GET["venda"]));
            $arrayFinal = [];
            $arraySimples = explode(',', $respDAOId['item']);
            foreach ($arraySimples as $linha) {
                $value = explode(';', $linha);
                array_push($arrayFinal, $value);
            }
            $horaData = explode(' - ', $respDAOId['venda']);
            View::renderTemplate('/pdv/comprovante-venda.html', ['itens'=>$arrayFinal, 'comprovante'=>$respDAOId, 'horaData'=>$horaData]); 
        }else{
            $respDAO = $obPdvDAO->tabelaComprovanteVenda();
            $arrayFinal = [];
            $arraySimples = explode(',', $respDAO['item']);
            foreach ($arraySimples as $linha) {
                $value = explode(';', $linha);
                array_push($arrayFinal, $value);
            }
            $horaData = explode(' - ', $respDAO['venda']);
            View::renderTemplate('/pdv/comprovante-venda.html', ['itens'=>$arrayFinal, 'comprovante'=>$respDAO, 'horaData'=>$horaData]); 
        }
    }

}