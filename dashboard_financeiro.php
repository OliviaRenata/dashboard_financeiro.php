<?php 
session_start(); // Certifique-se de que a sessão iniciou
$idempresa = $_SESSION['idempresa']; // Ou o nome da variável de sessão que seu sistema usa
if (isset($_SESSION['logado'])) {
    require "core/mysql.php";

    require "bin/funcoes.bin.php";
    require "version.php";
    $pageid = "dashboard";
    $pagenum = "1";
    require "core/controleDePermissoes.php"; 

    // Criar instância da classe correta
  $localsql  = new localsql();

    

    // Buscar dados financeiros (substituir pelos métodos financeiros reais)
    $saldoCaixa = $localsql->getSaldoCaixa($idempresa, $pdom);
    $contasReceber = $localsql->getContasReceber($idempresa, $pdom);
    $contasPagar = $localsql->getContasPagar($idempresa, $pdom);
    $indicadoresFinanceiros = $localsql->getIndicadoresFinanceiros($idempresa, $pdom);
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php require "core/header.php"; ?>

<style>

    .bg-primary {
   background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)
}

    .bg-info {
     background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)
}

    .bg-warning {
     background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)
}

    .bg-danger {
     background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)
}

    .text-success {
    color: #0688bb !important;
}
    :root {
        --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --card-hover-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        --transition-speed: 0.3s;
        --card-height: 120px;
        --finance-green: #0688bb;
        --finance-red: #4488ef;
        --finance-blue: #3b82f6;
        --finance-yellow: #0b97f5;
        --finance-purple: #5c6bf6;
    }

    .company-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);
        position: relative;
        overflow: hidden;
    }

    .company-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        transform: rotate(45deg);
    }

    .company-header h3 {
        color: white;
        font-weight: 700;
        font-size: 2.2rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 2;
    }

    .company-icon {
        position: absolute;
        right: 2rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.3);
        z-index: 1;
    }

    .user-welcome {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border: 1px solid #3b82f6;
        border-radius: 15px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        box-shadow: 0 5px 20px rgba(59, 130, 246, 0.1);
    }

    .user-welcome h2 {
        color: #1e3a8a;
        font-weight: 600;
        font-size: 1.8rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-icon {
        background: linear-gradient(135deg, #3b82f6, #1e3a8a);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .welcome-text {
        font-size: 0.9rem;
        color: #475569;
        margin-top: 0.5rem;
        font-style: italic;
    }

    /* CARDS FINANCEIROS */
    .stats-container {
        margin-top: 2rem;
    }

    .card-stat {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all var(--transition-speed) ease;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        box-shadow: var(--card-shadow);
        background: white;
        border-left: 4px solid;
    }

    .card-stat.saldo-total {
        border-left-color: var(--finance-green);
    }

    .card-stat.contas-receber {
        border-left-color: var(--finance-blue);
    }

    .card-stat.contas-pagar {
        border-left-color: var(--finance-red);
    }

    .card-stat.fluxo-caixa {
        border-left-color: var(--finance-purple);
    }

    .card-stat.adiantamentos {
        border-left-color: var(--finance-yellow);
    }

    .card-stat.provisionamentos {
        border-left-color: #6366f1;
    }

    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow) !important;
    }

    .card-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        z-index: -1;
    }

    .stat-icon {
        font-size: 2.2rem;
        opacity: 0.8;
        transition: all var(--transition-speed) ease;
        min-width: 50px;
        text-align: center;
    }

    .card-stat:hover .stat-icon {
        transform: scale(1.1);
        opacity: 1;
    }

    .stat-content {
        flex: 1;
        text-align: right;
        min-width: 0;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
        font-weight: 600;
        line-height: 1.2;
        color: #6c757d;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 1.2;
        margin: 0;
    }

    .stat-value.positive {
        color: var(--finance-green);
    }

    .stat-value.negative {
        color: var(--finance-red);
    }

    .stat-value.neutral {
        color: #475569;
    }

    .click-text {
        position: absolute;
        right: 0.2rem;
        font-size: 0.65rem;
        color: #3b82f6 !important;
        writing-mode: vertical-rl;
        text-orientation: mixed;
        font-weight: bold;
        opacity: 0;
        transform: translateY(10px);
        transition: all var(--transition-speed) ease;
    }

    .card-stat:hover .click-text {
        opacity: 1;
        transform: translateY(0);
    }

    /* ANIMAÇÕES */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .company-header,
    .user-welcome {
        animation: fadeInUp 0.6s ease-out;
    }

    .user-welcome {
        animation-delay: 0.2s;
        animation-fill-mode: both;
    }

    .dashboard-section {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    /* INDICADORES FINANCEIROS */
    .finance-indicators {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .indicator-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border-top: 4px solid;
    }

    .indicator-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .indicator-card.receita {
        border-top-color: var(--finance-green);
    }

    .indicator-card.despesa {
        border-top-color: var(--finance-red);
    }

    .indicator-card.lucro {
        border-top-color: var(--finance-blue);
    }

    .indicator-card.margem {
        border-top-color: var(--finance-purple);
    }

    .indicator-title {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .indicator-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .indicator-trend {
        display: inline-flex;
        align-items: center;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        margin-top: 0.5rem;
    }

    .trend-positive {
        background-color: #dcfce7;
        color: var(--finance-green);
    }

    .trend-negative {
        background-color: #fee2e2;
        color: var(--finance-red);
    }

    .trend-neutral {
        background-color: #f1f5f9;
        color: #64748b;
    }

    /* TABELAS FINANCEIRAS */
    .table-finance {
        font-size: 0.85rem;
    }

    .table-finance th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
        border-top: none;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .status-badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
    }

    .status-pago {
        background-color: #dcfce7;
        color: var(--finance-green);
    }

    .status-pendente {
        background-color: #fef3c7;
        color: var(--finance-yellow);
    }

    .status-atrasado {
        background-color: #fee2e2;
        color: var(--finance-red);
    }

    .status-provisionado {
        background-color: #e0e7ff;
        color: var(--finance-purple);
    }

    /* GRÁFICOS FINANCEIROS */
    .graficos-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-top: 2rem;
    }

    .grafico-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .grafico-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .grafico-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 1rem 1.25rem;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .grafico-header i {
        margin-right: 8px;
        font-size: 1.2rem;
    }

    .grafico-body {
        padding: 1.5rem;
        height: 300px;
        position: relative;
    }

    .grafico-wide {
        grid-column: span 2;
    }

    /* ALERTAS FINANCEIROS */
    .alertas-financeiros {
        margin-top: 2rem;
    }

    .alerta-card {
        border-left: 4px solid;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .alerta-atraso {
        border-left-color: var(--finance-red);
        background-color: #fef2f2;
    }

    .alerta-vencimento {
        border-left-color: var(--finance-yellow);
        background-color: #fffbeb;
    }

    .alerta-baixo-saldo {
        border-left-color: var(--finance-red);
        background-color: #fef2f2;
    }

    .alerta-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alerta-text {
        flex: 1;
    }

    .alerta-titulo {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #1e293b;
    }

    .alerta-descricao {
        font-size: 0.85rem;
        color: #64748b;
    }

    .alerta-valor {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
    }

    /* RESPONSIVIDADE */
    @media (max-width: 1400px) {
        .graficos-container {
            grid-template-columns: 1fr;
        }
        
        .grafico-wide {
            grid-column: span 1;
        }
    }

    @media (max-width: 768px) {
        .finance-indicators {
            grid-template-columns: 1fr 1fr;
        }
        
        .graficos-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .finance-indicators {
            grid-template-columns: 1fr;
        }
        
        .company-header {
            padding: 1.25rem;
        }
        
        .company-header h3 {
            font-size: 1.5rem;
        }
        
        .user-welcome h2 {
            font-size: 1.3rem;
        }
    }

    /* BOTÕES DE AÇÃO */
    .finance-actions {
        display: flex;
        gap: 0.75rem;
        margin: 1.5rem 0;
        flex-wrap: wrap;
    }

    .btn-finance {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-caixa {
        background: linear-gradient(135deg, var(--finance-green), #055096);
        color: white;
    }

    .btn-receber {
        background: linear-gradient(135deg, var(--finance-blue), #2563eb);
        color: white;
    }

    .btn-pagar {
        background: linear-gradient(135deg, var(--finance-red), #267bdc);
        color: white;
    }

    .btn-relatorio {
        background: linear-gradient(135deg, var(--finance-purple), #7c3aed);
        color: white;
    }

    .btn-finance:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* FILTROS DE PERÍODO */
    .periodo-filtros {
        display: flex;
        gap: 0.75rem;
        margin: 1rem 0;
        flex-wrap: wrap;
    }

    .btn-periodo {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
        transition: all 0.2s ease;
    }

    .btn-periodo:hover,
    .btn-periodo.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    /* RESUMO FINANCEIRO */
    .resumo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 1.5rem 0;
    }

    .resumo-item {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .resumo-titulo {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .resumo-valor {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .resumo-variacao {
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .variacao-positiva {
        color: var(--finance-green);
    }

    .variacao-negativa {
        color: var(--finance-red);
    }
</style>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Sidebar Start -->
        <?php require "home/home.sidebar.php" ?>
        <!-- Sidebar End -->
        
        <!-- Topbar Start -->
        <?php require "home/home.topbar.php" ?>
        <!-- Topbar End -->

        <!-- Content Start -->
        <div id="content" class="container-fluid pt-4 px-4">
    <div class="company-header">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Lado esquerdo -->
                        <div>
                            <h3>Dashboard Financeiro </h3>

                            <div class="user-info-company">
                                <i class="fas fa-user me-2"></i>
                                <?= $_SESSION['idlogin']; ?>.<?= $_SESSION['nome']; ?>
                            </div>
                        </div>


                    <!-- Lado direito -->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Saldo Total -->
                        <div class="card-stat saldo-total border">
                            <i class="fa-solid fa-wallet stat-icon text-success"></i>
                            <div class="stat-content text-end">
                                <p class="stat-label mb-1">Saldo Total</p>
                                <h6 id="saldoTotal" class="stat-value positive mb-0">
                                    R$ 0,00
                                </h6>
                            </div>
                        </div>

                        <!-- Ícone da empresa -->
                        <i class="fas fa-building company-icon"></i>
                    </div>
                </div>
            </div>

            <!-- User Welcome -->


   
            <!-- Gráficos Financeiros -->
<div class="row g-0 justify-content-center">
    
    <div class="col-12 col-md-6 g-2">
        <div class="grafico-card h-100 border shadow-sm">
            <div class="grafico-header p-3 text-white fw-bold" style="background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)">
                <i class="fas fa-exchange-alt me-2"></i> Fluxo de Caixa (Últimos 30 dias)
            </div>
            <div class="grafico-body p-3 bg-white">
                <canvas id="graficoFluxoCaixa"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 g-2">
        <div class="grafico-card h-100 border shadow-sm">
            <div class="grafico-header p-3 text-white fw-bold" style="background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)">
                <i class="fas fa-calendar-day me-2"></i> Contas a Vencer (Próximos 15 dias)
            </div>
            <div class="grafico-body p-3 bg-white">
                <canvas id="graficoContasVencer"></canvas>
            </div>
        </div>
    </div>
  
    <div class="pt-4 col-12 col-lg-10 mt-0 ">
        <div class="grafico-card border shadow-sm">
            <div class="grafico-header p-3 text-white fw-bold" style="background: linear-gradient(135deg, #009cff 0%, #0078cc 100%)">
                <i class="fas fa-chart-line me-2"></i> Evolução Financeira (Últimos 12 meses)
            </div>
            <div class="grafico-body p-3 bg-white">
                <canvas id="graficoEvolucao" style="min-height: 280px;"></canvas>
            </div>
        </div>
    </div>
</div>

            <!-- Tabelas Financeiras -->
<div class="row mt-4">
    <!-- Contas a Receber -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-hand-holding-usd me-2"></i>
                Contas a Receber (Últimas 10)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-finance mb-0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th class="text-center">Vencimento</th>
                                <th class="text-end">Saldo</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaContasReceber"></tbody>
                    </table>
                </div>

<div class="text-center my-2">
    <button id="verMaisContasReceber" class="btn btn-primary btn-sm" onclick="verMaisContasReceber()" style="display: none;">
        Ver mais
    </button>
</div>
            </div>
        </div>
    </div>




                <!-- Contas a Pagar -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-money-check-alt me-2"></i>
                            Contas a Pagar (Últimas 10)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-finance mb-0">
                                    <thead>
                                        <tr>
                                            <th>Fornecedor</th>
                                            <th class="text-center">Vencimento</th>
                                            <th class="text-end">Valor</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelaContasPagar">
                                        <tr>
                                            <td colspan="4" class="text-center">Carregando...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row mt-2">
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <i class="fas fa-forward me-2"></i>
                Adiantamentos Pendentes
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-finance mb-0">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Beneficiário</th>
                                <th class="text-center">Data</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaAdiantamentos">
                            <tr>
                                <td colspan="4" class="text-center">Carregando...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
<div class="text-center mt-2 mb-2">
<button id="verMaisAdiantamentosBtn" class="btn btn-sm btn-primary">
    Ver mais
</button>
</div>
            </div>
        </div>
    </div>



                
                <!-- Provisionamentos -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-chart-bar me-2"></i>
                            Provisionamentos (Este Mês)
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-finance mb-0">
                                    <thead>
                                        <tr>
                                            <th>Categoria</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-end">Previsto</th>
                                            <th class="text-end">Realizado</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelaProvisionamentos">
                                        <tr>
                                            <td colspan="4" class="text-center">Carregando...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require "home/home.back.to.top.php" ?>
            <?php require "core/importacoes_js.php"; ?>
            <?php require "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ===================================================
    // CONFIGURAÇÕES E CONSTANTES
    // ===================================================
    const API_BASE = 'core/dashboardFinanceiro.php';
    let periodoAtual = 'mes';
    let graficos = {};

    // ===================================================
    // FUNÇÕES DE FORMATAÇÃO FINANCEIRA
    // ===================================================
    function formatarNumero(num) {
        return new Intl.NumberFormat('pt-BR').format(num || 0);
    }

    function formatarBRL(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(valor || 0);
    }

    function formatarPercentual(valor) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'percent',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format((valor || 0) / 100);
    }

    function formatarData(data) {
        if (!data) return '';
        const d = new Date(data);
        return d.toLocaleDateString('pt-BR');
    }

    // ===================================================
    // FUNÇÕES PARA BUSCAR DADOS FINANCEIROS
    // ===================================================
    async function carregarSaldoTotal() {
        try {
            const response = await fetch(`${API_BASE}?acao=saldo_caixa`);
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            const data = await response.json();
            
            if (data && document.getElementById('saldoTotal')) {
                document.getElementById('saldoTotal').textContent = formatarBRL(data.saldo_total || 0);
            }
        } catch (error) {
            console.error('Erro ao buscar saldo total:', error);
        }
    }

    async function carregarIndicadoresFinanceiros() {
        try {
            const response = await fetch(`${API_BASE}?acao=indicadores_financeiros&periodo=${periodoAtual}`);
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            const data = await response.json();
            
            atualizarIndicadores(data);
        } catch (error) {
            console.error('Erro ao buscar indicadores:', error);
        }
    }

    // ===================================================
    // CONTAS A RECEBER - COM PAGINAÇÃO
    // ===================================================
    const LIMITE_CONTAS_RECEBER = 10;
    let paginaContasReceber = 0;
    let dadosContasReceberCompletos = [];

    async function carregarContasReceber() {
        try {
            const response = await fetch(`${API_BASE}?acao=contas_receber&status=abertas&limit=100`);
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            const data = await response.json();
            
            // Armazena todos os dados
            dadosContasReceberCompletos = data.slice().reverse();
            
            // Mostra os primeiros 10
            atualizarTabelaContasReceber(true);
        } catch (error) {
            console.error('Erro ao buscar contas a receber:', error);
        }
    }

    function atualizarTabelaContasReceber(reset = false) {
        const tbody = document.getElementById('tabelaContasReceber');
        const verMaisBtn = document.getElementById('verMaisContasReceber');

        if (reset) {
            paginaContasReceber = 0;
            if (tbody) tbody.innerHTML = '';
        }

        if (!dadosContasReceberCompletos || dadosContasReceberCompletos.length === 0) {
            if (tbody) tbody.innerHTML = '<tr><td colspan="4" class="text-center">Nenhum registro encontrado</td></tr>';
            if (verMaisBtn) verMaisBtn.style.display = 'none';
            return;
        }

        // Pega apenas o pedaço de 10 registros baseado na página atual
        const inicio = paginaContasReceber * LIMITE_CONTAS_RECEBER;
        const fim = inicio + LIMITE_CONTAS_RECEBER;
        const bloco = dadosContasReceberCompletos.slice(inicio, fim);

        if (bloco.length === 0) {
            if (verMaisBtn) verMaisBtn.style.display = 'none';
            return;
        }

        bloco.forEach(item => {
            const status = item.SALDO > 0
                ? '<span class="badge bg-primary">Em aberto</span>'
                : '<span class="badge bg-success">Pago</span>';

            tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${item.nome_cliente ?? '-'}</td>
                    <td class="text-center">${formatarData(item.VCTO)}</td>
                    <td class="text-end">${formatarBRL(item.SALDO)}</td>
                    <td class="text-center">${status}</td>
                </tr>
            `);
        });

        // Incrementa a página para o próximo clique no "Ver Mais"
        paginaContasReceber++;

        // Gerencia o botão: só mostra se o total de dados for maior que o que já mostramos
        if (verMaisBtn) {
            verMaisBtn.style.display = (dadosContasReceberCompletos.length > fim) ? 'inline-block' : 'none';
        }
    }

    function verMaisContasReceber() {
        atualizarTabelaContasReceber(false);
    }

    async function carregarContasPagar() {
        try {
            const response = await fetch(`${API_BASE}?acao=contas_pagar&status=abertas&limit=10`);
            if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
            const data = await response.json();

            atualizarTabelaContasPagar(data);
        } catch (error) {
            console.error('Erro ao buscar contas a pagar:', error);
        }
    }

// ===================================================
// GESTÃO DE ADIANTAMENTOS PENDENTES - VERSÃO CORRIGIDA
// ===================================================
const LIMITE_ADIANTAMENTOS = 10;
let paginaAdiantamentosAtual = 0;
let dadosAdiantamentos = [];
let adiantamentosVisiveis = 0; // Contador de itens visíveis

async function carregarAdiantamentos(reset = false) {
    try {
        if (reset) {
            paginaAdiantamentosAtual = 0;
            dadosAdiantamentos = [];
            adiantamentosVisiveis = 0;
        }

        // Calcula o offset
        const offset = paginaAdiantamentosAtual * LIMITE_ADIANTAMENTOS;
        
        // Busca dados
        const response = await fetch(`${API_BASE}?acao=adiantamentos_pendentes&tipo=pagar&limit=${LIMITE_ADIANTAMENTOS}&offset=${offset}`);
        
        if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
        
        const res = await response.json();
        const novosDados = res.contas_receber_abertas || res || [];

        // Adiciona novos dados
        dadosAdiantamentos = dadosAdiantamentos.concat(novosDados);
        
        // Incrementa página para próxima busca
        paginaAdiantamentosAtual++;

        // Atualiza a tabela (sempre mostra apenas os visíveis)
        renderizarTabelaAdiantamentos();

        // Controla visibilidade do botão
        const btn = document.getElementById('verMaisAdiantamentosBtn');
        if (btn) {
            // Esconde se não trouxe mais dados
            btn.style.display = (novosDados.length === 0 || novosDados.length < LIMITE_ADIANTAMENTOS) 
                ? 'none' 
                : 'inline-block';
        }

    } catch (error) {
        console.error('Erro ao buscar adiantamentos:', error);
        const btn = document.getElementById('verMaisAdiantamentosBtn');
        if (btn) btn.style.display = 'none';
    }
}

function renderizarTabelaAdiantamentos() {
    const tbody = document.getElementById('tabelaAdiantamentos');
    if (!tbody) return;

    if (!Array.isArray(dadosAdiantamentos) || dadosAdiantamentos.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Nenhum adiantamento pendente</td></tr>`;
        return;
    }

    // Calcula quantos itens mostrar (acumulativo)
    adiantamentosVisiveis += LIMITE_ADIANTAMENTOS;
    
    // Limita para não mostrar mais que o total disponível
    const limite = Math.min(adiantamentosVisiveis, dadosAdiantamentos.length);
    
    // Pega apenas os itens a serem mostrados
    const dadosParaMostrar = dadosAdiantamentos.slice(0, limite);

    // Renderiza apenas os dados visíveis
    tbody.innerHTML = dadosParaMostrar.map(item => {
        const badgeClass = 'bg-warning';
        const badgeText = 'A Pagar';
        const statusClass = Number(item.SALDO) > 0 ? 'text-danger' : 'text-success';

        return `
            <tr>
                <td><span class="badge ${badgeClass}">${badgeText}</span></td>
                <td>${item.nome_cliente || item.beneficiario || item.nome_fornecedor || 'Não informado'}</td>
                <td class="text-center">${formatarData(item.VCTO || item.data || item.data_vencimento)}</td>
                <td class="text-end fw-bold ${statusClass}">${formatarBRL(item.SALDO || item.valor || item.valor_total)}</td>
            </tr>
        `;
    }).join('');

    // Atualiza o contador de visíveis (se ultrapassou o total)
    adiantamentosVisiveis = Math.min(adiantamentosVisiveis, dadosAdiantamentos.length);
}

function verMaisAdiantamentos() {
    carregarAdiantamentos(false); // false = não resetar, apenas adicionar mais
}


async function carregarProvisionamentos(categoria = null, periodo = 'mes') {
    try {
        let url = `${API_BASE}?acao=provisionamentos_categoria&periodo=${periodo}`;
        if (categoria) url += `&categoria=${categoria}`;

        const response = await fetch(url);
        if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);
        
        const data = await response.json();

        if (data.error) {
            console.error('Erro no PHP:', data.message);
            
            // Mostrar mensagem de erro na tabela
            const tbody = document.getElementById('tabelaProvisionamentos');
            if (tbody) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Erro ao carregar provisionamentos: ${data.message}
                        </td>
                    </tr>
                `;
            }
            return;
        }

        // Garante que data seja array
        atualizarTabelaProvisionamentos(Array.isArray(data) ? data : []);
        
    } catch (error) {
        console.error('Erro ao buscar provisionamentos:', error);
        
        const tbody = document.getElementById('tabelaProvisionamentos');
        if (tbody) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-danger">
                        Erro ao buscar provisionamentos: ${error.message}
                    </td>
                </tr>
            `;
        }
    }
}

    // ===================================================
    // FUNÇÕES PARA ATUALIZAR A INTERFACE
    // ===================================================
    function atualizarIndicadores(data) {
        const container = document.getElementById('indicadoresFinanceiros');
        if (!container) return;
        
        const indicadores = [
            {
                titulo: 'Receita Total',
                valor: formatarBRL(data.receita_total || 0),
                variacao: data.variacao_receita || 0,
                classe: 'receita'
            },
            {
                titulo: 'Despesas Totais',
                valor: formatarBRL(data.despesas_total || 0),
                variacao: data.variacao_despesas || 0,
                classe: 'despesa'
            },
            {
                titulo: 'Lucro Líquido',
                valor: formatarBRL(data.lucro_liquido || 0),
                variacao: data.variacao_lucro || 0,
                classe: 'lucro'
            },
            {
                titulo: 'Margem de Lucro',
                valor: formatarPercentual(data.margem_lucro || 0),
                variacao: data.variacao_margem || 0,
                classe: 'margem'
            }
        ];
        
        container.innerHTML = indicadores.map(ind => `
            <div class="indicator-card ${ind.classe}">
                <div class="indicator-title">${ind.titulo}</div>
                <div class="indicator-value">${ind.valor}</div>
                ${ind.variacao ? `
                    <div class="indicator-trend ${ind.variacao >= 0 ? 'trend-positive' : 'trend-negative'}">
                        <i class="fas fa-${ind.variacao >= 0 ? 'arrow-up' : 'arrow-down'} me-1"></i>
                        ${Math.abs(ind.variacao).toFixed(1)}%
                    </div>
                ` : ''}
            </div>
        `).join('');
    }

    function atualizarAlertas(data) {
        const container = document.getElementById('alertasFinanceiros');
        if (!container) return;
        
        if (!data || data.length === 0) {
            container.innerHTML = `
                <div class="text-center text-muted py-3">
                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                    <p>Nenhum alerta financeiro no momento</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = data.map(alerta => `
            <div class="alerta-card ${alerta.tipo === 'atraso' ? 'alerta-atraso' : 
                                     alerta.tipo === 'vencimento' ? 'alerta-vencimento' : 
                                     'alerta-baixo-saldo'}">
                <div class="alerta-content">
                    <div class="alerta-text">
                        <div class="alerta-titulo">${alerta.titulo}</div>
                        <div class="alerta-descricao">${alerta.descricao}</div>
                    </div>
                    <div class="alerta-valor">${formatarBRL(alerta.valor)}</div>
                </div>
            </div>
        `).join('');
    }

    function atualizarTabelaContasPagar(data) {
        const tbody = document.getElementById('tabelaContasPagar');
        if (!tbody) return;

        if (!data || data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Nenhuma conta a pagar em aberto
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = data.map(conta => {
            const statusClass = conta.STATUS == 0 ? 'status-pago' : 'status-pendente';
            const statusText = conta.STATUS == 0 ? 'Quitada' : 'Aberta';

            return `
                <tr>
                    <td>${conta.nome_fornecedor || 'Não informado'}</td>
                    <td class="text-center">${conta.VCTO}</td>
                    <td class="text-end fw-bold">${parseFloat(conta.VALOR).toFixed(2)}</td>
                    <td class="text-center">
                        <span class="status-badge ${statusClass}">${statusText}</span>
                    </td>
                </tr>
            `;
        }).join('');
    }

 function atualizarTabelaProvisionamentos(data) {
    const tbody = document.getElementById('tabelaProvisionamentos');
    if (!tbody) return;

    if (!data || data.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted">
                    Nenhum provisionamento registrado
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = data.map(prov => {
        // Traduz tipo para "Despesa" ou "Receita"
        const tipoLabel = prov.tipo && prov.tipo.toUpperCase() === 'PAG' ? 'Despesa' : 'Receita';
        const tipoClass = tipoLabel === 'Despesa' ? 'bg-danger' : 'bg-success';

        return `
            <tr>
                <td>${prov.idhistorico || 'Não informado'}</td> <!-- categoria/histórico -->
                <td class="text-center">
                    <span class="badge ${tipoClass}">${tipoLabel}</span>
                </td>
                <td class="text-end">${formatarBRL(prov.valor)}</td> <!-- valor previsto -->
                <td class="text-end fw-bold">${formatarBRL(prov.valor)}</td> <!-- saldo/referência -->
            </tr>
        `;
    }).join('');
}


    // ===================================================
    // FUNÇÕES PARA GRÁFICOS FINANCEIROS
    // ===================================================
    async function carregarGraficoFluxoCaixa() {
        try {
            const response = await fetch(`${API_BASE}?acao=fluxo_caixa&periodo=30dias`);
            const data = await response.json();
            
            const canvas = document.getElementById('graficoFluxoCaixa');
            if (!canvas) return;
            
            // Destruir gráfico anterior se existir
            if (graficos.fluxoCaixa) {
                graficos.fluxoCaixa.destroy();
            }
            
            const ctx = canvas.getContext('2d');
            graficos.fluxoCaixa = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.fluxo?.map(item => item.data?.split('-').reverse().slice(1).join('/')) || [],
                    datasets: [
                        {
                            label: 'Recebimentos',
                            data: data.fluxo?.map(item => item.recebimentos) || [],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Pagamentos',
                            data: data.fluxo?.map(item => item.pagamentos) || [],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Saldo Acumulado',
                            data: data.fluxo?.map(item => item.saldo_acumulado) || [],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Movimentação Diária (R$)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return formatarBRL(value);
                                }
                            }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Saldo Acumulado (R$)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return formatarBRL(value);
                                }
                            },
                            grid: {
                                drawOnChartArea: false
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += formatarBRL(context.parsed.y);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Erro ao carregar gráfico de fluxo de caixa:', error);
        }
    }

    async function carregarGraficoContasVencer() {
        try {
            const response = await fetch(`${API_BASE}?acao=grafico_contas_vencer&dias=15`);
            const data = await response.json();
            
            const canvas = document.getElementById('graficoContasVencer');
            if (!canvas) return;
            
            if (graficos.contasVencer) {
                graficos.contasVencer.destroy();
            }
            
            const ctx = canvas.getContext('2d');
            graficos.contasVencer = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels || [],
                    datasets: [
                        {
                            label: 'Contas a Receber',
                            data: data.receber || [],
                            backgroundColor: 'rgba(59, 130, 246, 0.8)',
                            borderColor: '#3b82f6',
                            borderWidth: 1
                        },
                        {
                            label: 'Contas a Pagar',
                            data: data.pagar || [],
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderColor: '#ef4444',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatarBRL(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${formatarBRL(context.parsed.y)}`;
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Erro ao carregar gráfico de contas a vencer:', error);
        }
    }

    async function carregarGraficoEvolucao() {
        try {
            const response = await fetch(`${API_BASE}?acao=evolucao_financeira&periodo=12meses`);
            const data = await response.json();
            
            const canvas = document.getElementById('graficoEvolucao');
            if (!canvas) return;
            
            if (graficos.evolucao) {
                graficos.evolucao.destroy();
            }
            
            const ctx = canvas.getContext('2d');
            graficos.evolucao = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.meses || [],
                    datasets: [
                        {
                            label: 'Receita',
                            data: data.receitas || [],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Despesas',
                            data: data.despesas || [],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Lucro',
                            data: data.lucros || [],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return formatarBRL(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${formatarBRL(context.parsed.y)}`;
                                }
                            }
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Erro ao carregar gráfico de evolução:', error);
        }
    }

    // ===================================================
    // FUNÇÕES DE CONTROLE E EVENTOS
    // ===================================================
    function mudarPeriodo(novoPeriodo) {
        periodoAtual = novoPeriodo;
        
        // Atualizar botões ativos
        document.querySelectorAll('.btn-periodo').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.periodo === novoPeriodo) {
                btn.classList.add('active');
            }
        });
        
        // Recarregar dados do período
        carregarIndicadoresFinanceiros();
        carregarGraficoFluxoCaixa();
        carregarGraficoContasVencer();
        carregarGraficoEvolucao();
    }

    function abrirCaixa() {
        alert('Abrir módulo de Caixa');
        // Implementar abertura do caixa
    }

    function abrirContasReceber() {
        alert('Abrir módulo de Contas a Receber');
        // Implementar abertura de contas a receber
    }

    function abrirContasPagar() {
        alert('Abrir módulo de Contas a Pagar');
        // Implementar abertura de contas a pagar
    }

    function gerarRelatorio() {
        alert('Gerar relatório financeiro');
        // Implementar geração de relatório
    }

    // ===================================================
    // INICIALIZAÇÃO DO DASHBOARD
    // ===================================================
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar eventos dos botões de período
        document.querySelectorAll('.btn-periodo').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.dataset.periodo !== 'personalizado') {
                    mudarPeriodo(this.dataset.periodo);
                } else {
                    alert('Selecionar período personalizado');
                    // Implementar seletor de datas
                }
            });
        });

        // Configurar botões "Ver mais"
        const btnVerMaisContasReceber = document.getElementById('verMaisContasReceber');
        if (btnVerMaisContasReceber) {
            btnVerMaisContasReceber.addEventListener('click', verMaisContasReceber);
        }

        const btnVerMaisAdiantamentos = document.getElementById('verMaisAdiantamentosBtn');
        if (btnVerMaisAdiantamentos) {
            btnVerMaisAdiantamentos.addEventListener('click', verMaisAdiantamentos);
        }

        // Carregar todos os dados inicialmente
        const carregamentos = [
            carregarSaldoTotal(),
            carregarIndicadoresFinanceiros(),
            carregarContasReceber(),
            carregarContasPagar(),
            carregarAdiantamentos(true), // true para reset inicial
            carregarProvisionamentos(),
            carregarGraficoFluxoCaixa(),
            carregarGraficoContasVencer(),
            carregarGraficoEvolucao()
        ];

        Promise.allSettled(carregamentos).then(results => {
            results.forEach((result, index) => {
                if (result.status === 'rejected') {
                    console.warn(`Falha ao carregar dados ${index}:`, result.reason);
                }
            });
        });

        // Configurar atualizações periódicas
        setInterval(carregarSaldoTotal, 60000); // 1 minuto
        setInterval(carregarIndicadoresFinanceiros, 300000); // 5 minutos

        // Animar cards
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.card-stat, .indicator-card, .grafico-card').forEach(card => {
            observer.observe(card);
        });
    });

    // Expor funções para uso global
    window.dashboardFinanceiro = {
        carregarSaldoTotal,
        carregarIndicadoresFinanceiros,
        carregarContasReceber,
        carregarContasPagar,
        carregarAdiantamentos,
        carregarProvisionamentos,
        carregarGraficoFluxoCaixa,
        carregarGraficoContasVencer,
        carregarGraficoEvolucao,
        mudarPeriodo,
        formatarBRL,
        formatarPercentual,
        formatarData,
        verMaisContasReceber,
        verMaisAdiantamentos
    };
</script>
<?php
} else {
    header('Location:signin');
}
?>
</body>
</html>