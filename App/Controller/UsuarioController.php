<?php

namespace App\Controller;

use App\Repository\UsuarioDAO;
use Core\View;

class UsuarioController
{
    public function usuarioAdd()
    {
        $obUsuario = new UsuarioDAO();
    
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $result = $obUsuario->registroUsuario($_POST);
            View::jsonResponse($result);
        }
    
        $validar = false;
        $usuarioAdm = $obUsuario->verificaAdm();
        if(count($usuarioAdm)>0){
            $validar = true;
        }
        View::renderTemplate('/usuario/usuario.html', ['validar'=>$validar]); 
    }

    public function tabelaUsuario()
    {
        $busca= "";
        $pagina= 1;
        $itensPag= 10;

        if(isset($_GET['busca'])){
            $busca = $_GET['busca'];
        }
        if(isset($_GET['pagina'])){
            $pagina = $_GET['pagina'];
        }
        if(isset($_GET['itensPag'])){
            $itensPag = $_GET['itensPag'];
        }

        $obUsuarioDAO = new UsuarioDAO();
        $resp = $obUsuarioDAO->tabUsuario($busca, $pagina, $itensPag);
        $total = $obUsuarioDAO->qntTotalUsuarios($busca);
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/usuario/tabelaUsuario.html', ['usuarios'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/tab-usuario', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function obterUsuario()
    {
        $obUsuario = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obUsuario->obterUsuario($_POST);
            View::jsonResponse($resp);
        }
    }

    public function inativarUsuario()
    {
        $obUsuario = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $resp = $obUsuario->inativarUsuario($_POST);
            View::jsonResponse($resp);
        }
    }

    public function atualizaUsuario()
    {
        $obUsuarioDAO = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $obUsuario=array(
                'id'=>intval($_POST['idUsuario']),
                'nomeU'=>$_POST['nomeU'],
                'sobrenomeU'=>$_POST['sobrenomeU'],
                'emailU'=>$_POST['emailU'],
                'cargoU'=>$_POST['cargoU'],
                'statusU'=>intval($_POST['statusU']) 
            );
            $resp = $obUsuarioDAO->atualizarUsuario($obUsuario);
            View::jsonResponse($resp);
        }
    }

    /**
     * Tras o usuario para a tela de relatorio
     */
    public function usuarioVendas()
    {   
        $obUsuarioDAO = new UsuarioDAO();
        if($_GET['usuario']){
            $resp = $obUsuarioDAO->exibirUsuario(intval($_GET["usuario"]));
            View::renderTemplate('/usuario/usuario-venda.html', ['usuario'=>$resp]); 
        }
    }

    public function relatorioVendasUsuario()
    {
        $obUsuarioDAO = new UsuarioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario=array(
                'idUsuario'=> intval($_POST['idUsuario']),
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVendasGeral = $obUsuarioDAO->vendaUsuarioData($usuario);
            $respVendasPeriodo = $obUsuarioDAO->vendaUsuarioPeriodo($usuario);
            View::jsonResponse(['vendaTotal'=>$respVendasGeral, 'vendaPeriodo'=>$respVendasPeriodo]);
        }
    }
    
}