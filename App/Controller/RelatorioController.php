<?php

namespace App\Controller;

use App\Repository\RelatorioDAO;
use Core\View;
use mikehaertl\wkhtmlto\Pdf;

class RelatorioController
{
    public function produtosMaisVendidos()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respProdutosPeriodo = $obRelatorioDAO->maisVendidos($datas);
            View::jsonResponse(['maisVendidos'=>$respProdutosPeriodo]);
        }
        View::renderTemplate('/relatorios/mais-vendidos.html'); 
    }

    public function statusComanda()
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

        $datas=array(
            'dtInicial' => $_POST['dtInicial'],
            'dtFinal' => $_POST['dtFinal']
        );

        $obRelatorioDAO = new RelatorioDAO();
        $resp = $obRelatorioDAO->mostrarComanda($datas, $pagina, $itensPag);
        $total = $obRelatorioDAO->qntTotalComanda();
        $totalpaginas =  ceil($total['total'] / $itensPag);

        View::renderTemplate('/relatorios/comanda-status.html', ['comanda'=>$resp, 'total'=>intval($total['total']), 'totalpaginas'=>$totalpaginas, 'route'=>'/comanda-status', 'busca'=>$busca, 'itensPag'=>$itensPag, 'pagina'=>intval($pagina)]);
    }

    public function comanda()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respComanda = $obRelatorioDAO->vendaComandas($datas);
            View::jsonResponse(['comandas'=>$respComanda]);
        }
        View::renderTemplate('/relatorios/comanda-status.html'); 
    }

    public function colaboradoresVendas()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVendasPeriodo = $obRelatorioDAO->vendasPeriodoColaboradores($datas);
            View::jsonResponse(['colaboradores'=>$respVendasPeriodo]);
        }
        View::renderTemplate('/relatorios/vendas-colaboradores.html'); 
    }

    public function verLancamentoVenda()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $resp = $obRelatorioDAO->lancamentoVenda($datas);
            View::jsonResponse(['relatorio'=>$resp]);
        }
        View::renderTemplate('/relatorios/status-anual.html');
    }

    public function vendaPeriodo()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVenda = $obRelatorioDAO->vendaPeriodo($datas);
            View::jsonResponse(['venda'=>$respVenda]);
        }
        View::renderTemplate('/relatorios/vendas.html');
    }

    public function vendasPdf()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $datas=array(
                'dtInicial' => $_POST['dtInicial'],
                'dtFinal' => $_POST['dtFinal']
            );
            $respVenda = $obRelatorioDAO->vendaPeriodoPdf($datas);
            
            foreach ($respVenda as $key => $venda) {
                $arraySimples = explode(',', $venda['item']);
                $respVenda[$key]['itemArray'] = $arraySimples;
            }
            // foreach ($respVenda as $key => $venda) {
            //     $arrayFinal = [];
            //     $arraySimples = explode(',', $venda['item']);
            //     foreach ($arraySimples as $linha) {
            //         $value = explode(';', $linha);
            //         array_push($arrayFinal, $value);
            //     }
            //     $respVenda[$key]['itemArray'] = $arrayFinal;
            // }
            
            $html = View::renderTemplateHtml('/relatorios/pdf/pdf-vendas.html', ['vendas'=>$respVenda]);
            $pdf = new Pdf($html);
            $pdf->binary = 'C:\Program Files\wkhtmltopdf\bin';
            $pdf->setOptions(['encoding'=>'UTF-8']);
            header('Content-type: application/pdf');
            $pdf->send('vendas.pdf');
        }
    }

    public function verLancamentoVendaPdf()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $obRelatorioDAO = new RelatorioDAO();
            $datas=array(
                'dtInicial' => $_GET['dtInicial'],
                'dtFinal' => $_GET['dtFinal']
            );
            $respVendaLancamento = $obRelatorioDAO->lancamentoVenda($datas);
            $html = View::renderTemplateHtml('/relatorios/pdf/pdf-status-anual.html', ['vendas'=>$respVendaLancamento]);
            $pdf = new Pdf($html);
            $pdf->setOptions(['encoding'=>'UTF-8']);
            header('Content-type: application/pdf');
            $pdf->send('vendas-lancamento.pdf');
        }
    }

    public function produtosMaisVendidosPdf()
    {
        $obRelatorioDAO = new RelatorioDAO();
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $datas=array(
                'dtInicial' => $_GET['dtInicial'],
                'dtFinal' => $_GET['dtFinal']
            );
            $respBrinquedoPeriodo = $obRelatorioDAO->maisVendidos($datas);
            $html = View::renderTemplateHtml('/relatorios/pdf/pdf-status-anual.html', ['brinquedos'=>$respBrinquedoPeriodo]);
            $pdf = new Pdf($html);
            $pdf->setOptions(['encoding'=>'UTF-8']);
            header('Content-type: application/pdf');
            $pdf->send('brinquedos.pdf');
        }
    }
}