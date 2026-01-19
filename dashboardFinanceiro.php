<?php
session_start();
require "mysql.php";
require "mysql_select.php";

// Instancia a classe Localsql
  $localsql  = new localsql();
  $sqlSelect = new sqlSelect();

// Verifica se o usuário está logado e se a empresa está definida
if (!isset($_SESSION['logado']) || !isset($_SESSION['idempresa'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

$idempresa = $_SESSION['idempresa'];

// Define cabeçalho JSON
header('Content-Type: application/json');

// Função para enviar resposta JSON e sair
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

try {
    // Ação recebida via GET
    $acao = $_GET['acao'] ?? null;

    switch ($acao) {

        // ========================
        // CONTROLE DE CAIXA FINANCEIRO
        // ========================


        case 'saldo_caixa':
            $dados = $sqlSelect->saldoCaixa($idempresa, $pdom);
            jsonResponse($dados);
            break;



case 'fluxo_caixa':
    $periodo = $_GET['periodo'] ?? '30dias';
    $dados   = $sqlSelect->fluxoCaixa($idempresa, $periodo, $pdom);
    jsonResponse($dados);
    break;


        // ========================
        // CONTAS A RECEBER
        // ========================
case 'contas_receber':

    // =========================
    // STATUS (abertas / pagas)
    // =========================
    $statusParam = $_GET['status'] ?? 'abertas';

    switch ($statusParam) {
        case 'abertas':
            $status = 'abertas'; // SALDO > 0
            break;

        case 'pagas':
            $status = 'quitadas'; // SALDO = 0
            break;

        default:
            $status = null; // todas
    }

    // =========================
    // FILTROS
    // =========================
    $cliente            = $_GET['cliente'] ?? null;
    $vencimento_inicio  = $_GET['vencimento_inicio'] ?? null;
    $vencimento_fim     = $_GET['vencimento_fim'] ?? null;
    $limit              = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;

    // =========================
    // CHAMADA DAO
    // =========================
    $dados = $sqlSelect->contasReceber(
        $idempresa,
        $status,
        $cliente,
        $vencimento_inicio,
        $vencimento_fim,
        
        $pdom // PDO real
    );

    jsonResponse($dados);
    break;



        // ========================
        // CONTAS A PAGAR
        // ========================

        case 'contas_pagar':
            $status = $_GET['status'] ?? 'abertas';
            $fornecedor = $_GET['fornecedor'] ?? null;
            $vencimento_inicio = $_GET['vencimento_inicio'] ?? null;
            $vencimento_fim = $_GET['vencimento_fim'] ?? null;
            $dados = $sqlSelect->contasPagar($idempresa, $status, $fornecedor, $vencimento_inicio, $vencimento_fim, $pdom);
            jsonResponse($dados);
            break;





        // ========================
        // ADIANTAMENTOS
        // ========================

        case 'adiantamentos_receber':
            $status = $_GET['status'] ?? 'pendentes';
            $dados = $sqlSelect->adiantamentosReceber($idempresa, $status, $pdom);
            jsonResponse($dados);
            break;

        case 'adiantamentos_pagar':
            $status = $_GET['status'] ?? 'pendentes';
            $dados = $sqlSelect->adiantamentosPagar($idempresa, $status, $pdom);
            jsonResponse($dados);
            break;

        // ========================
        // PROVISIONAMENTOS
        // ========================

        case 'provisionamentos':
            $tipo = $_GET['tipo'] ?? 'todos';
            $periodo = $_GET['periodo'] ?? 'mes';
            $dados = $sqlSelect->provisionamentos($idempresa,  $pdom);
            jsonResponse($dados);
            break;

    case 'provisionamentos_categoria':
        $categoria = $_GET['categoria'] ?? null;
        $periodo = $_GET['periodo'] ?? 'mes';
$dados = $sqlSelect->provisionamentosCategoria($idempresa, $categoria, $periodo, $pdom);


        jsonResponse($dados);
        break;


        // ========================
        // DASHBOARD FINANCEIRO
        // ========================

        case 'indicadores_financeiros':
            $periodo = $_GET['periodo'] ?? 'mes';
            $dados = $sqlSelect->indicadoresFinanceiros($idempresa,  $pdom);
            jsonResponse($dados);
            break;



    case 'grafico_contas_vencer':
        $dias  = (int)($_GET['dias'] ?? 30);
        $dados = $sqlSelect-> graficoContasVencer($idempresa, $dias, $pdom);
        jsonResponse($dados);
        break;


        case 'resumo_financeiro':
            $data = $_GET['data'] ?? date('Y-m-d');
            $dados = $sqlSelect->resumoFinanceiro($idempresa,  $pdom);
            jsonResponse($dados);
            break;

        // ========================
        // RELATÓRIOS E ANÁLISES
        // ========================



        case 'evolucao_financeira':
            $periodo = $_GET['periodo'] ?? '6meses';
            $dados = $sqlSelect-> evolucaoFinanceira($idempresa, $periodo, $pdom);
            jsonResponse($dados);
            break;




        // ========================
        // DEFAULT - RESUMO GERAL
        // ========================

        default:
            $response = [
                'resumo_financeiro' => $sqlSelect->resumoFinanceiro($idempresa,  $pdom) ?? [],
                'indicadores_financeiros' => $sqlSelect->indicadoresFinanceiros($idempresa,  $pdom) ?? [],
                'fluxo_caixa_30dias' => $sqlSelect->fluxoCaixa($idempresa, '30dias', $pdom) ?? [],
                'contas_receber_abertas' => $sqlSelect->contasReceber($idempresa, 'abertas', null, null, null, $pdom) ?? [],
                'contas_pagar_abertas' => $sqlSelect->contasPagar($idempresa, 'abertas', null, null, null, $pdom) ?? [],
                'provisionamentos_mes' => $sqlSelect->provisionamentos($idempresa,  $pdom) ?? [],
                'grafico_contas_vencer' => $sqlSelect->graficoContasVencer($idempresa, 30, $pdom) ?? []
            ];
            jsonResponse($response);
            break;
    }

} catch (Exception $e) {
    jsonResponse(['error' => $e->getMessage()], 500);
}
