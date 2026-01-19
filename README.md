📊 Dashboard Financeiro - Documentação Completa

📋 Índice

Visão Geral
Funcionalidades
Gráficos
Tabelas
Tecnologias
Instalação
Configuração
API Endpoints
Estrutura de Arquivos
Segurança
Responsividade
Contribuição
🎯 Visão Geral

O Dashboard Financeiro é uma solução completa para gestão financeira empresarial, oferecendo visualização em tempo real de indicadores críticos, análises gráficas avançadas e controle detalhado de movimentações financeiras.

✅ Principais Características

Monitoramento em tempo real do fluxo de caixa
Análises históricas de 12 meses
Projeções de contas a vencer
Controle completo de recebíveis e pagáveis
Interface responsiva e intuitiva
🚀 Funcionalidades

📈 Indicadores Principais

Indicador	Descrição	Atualização
Saldo Total	Saldo consolidado da empresa	A cada 1 minuto
Receita Total	Soma de todas as entradas	A cada 5 minutos
Despesas Totais	Soma de todas as saídas	A cada 5 minutos
Lucro Líquido	Receita - Despesas	A cada 5 minutos
Margem de Lucro	Percentual de lucratividade	A cada 5 minutos
🎛️ Controles Disponíveis

✅ Filtros temporais (dia, semana, mês, trimestre, ano)
✅ Paginação inteligente em tabelas
✅ Exportação de dados (em desenvolvimento)
✅ Alertas automáticos de vencimentos
✅ Comparativos período a período
📊 Gráficos

1. Fluxo de Caixa (30 dias)

javascript
Tipo: Gráfico de Linhas
Dados: Recebimentos, Pagamentos, Saldo Acumulado
Período: Últimos 30 dias
Interatividade: Tooltips com valores detalhados
2. Contas a Vencer (15 dias)

javascript
Tipo: Gráfico de Barras
Comparação: Contas a Receber vs Contas a Pagar
Período: Próximos 15 dias
Visualização: Por data de vencimento
3. Evolução Financeira (12 meses)

javascript
Tipo: Gráfico de Linhas Múltiplas
Métricas: Receita, Despesas, Lucro
Período: Últimos 12 meses
Análise: Tendência histórica
📋 Tabelas

1. Contas a Receber

Coluna	Tipo	Formato	Status
Cliente	Texto	-	-
Vencimento	Data	DD/MM/AAAA	-
Saldo	Monetário	R$ 1.234,56	🔵 Em aberto / 🟢 Pago
Status	Badge	-	Dinâmico
Recursos:

Paginação (10 em 10 registros)
Ordenação por data
Limite de 100 registros totais
Botão "Ver mais"
2. Contas a Pagar

Coluna	Tipo	Formato	Status
Fornecedor	Texto	-	-
Vencimento	Data	DD/MM/AAAA	-
Valor	Monetário	R$ 1.234,56	-
Status	Badge	-	🟢 Quitada / 🟡 Aberta
3. Adiantamentos Pendentes

Coluna	Tipo	Descrição
Tipo	Badge	"A Pagar" (laranja)
Beneficiário	Texto	Cliente/Fornecedor
Data	Data	Vencimento
Valor	Monetário	Valor do adiantamento
4. Provisionamentos

Coluna	Tipo	Cores
Categoria	Texto	-
Tipo	Badge	🔴 Despesa / 🟢 Receita
Previsto	Monetário	Valor orçado
Realizado	Monetário	Valor executado
🛠️ Tecnologias

Frontend

json
{
  "Chart.js": "3.9.1+ (Gráficos)",
  "Bootstrap": "5.x (UI Framework)",
  "Font Awesome": "6.x (Ícones)",
  "Vanilla JavaScript": "(Lógica de negócio)"
}
Backend

php
PHP: "7.4+"
PDO: "(Conexão com banco)"
MySQL: "(Banco de dados)"
Session: "(Autenticação)"
Estilos

css
CSS3: "(Estilos customizados)"
CSS Variables: "(Temas e cores)"
Flexbox/Grid: "(Layouts)"
Media Queries: "(Responsividade)"
⚙️ Instalação

Pré-requisitos

bash
# Servidor Web (Apache/Nginx)
# PHP 7.4 ou superior
# MySQL 5.7 ou superior
# Node.js (opcional para build)
Passos de Instalação

Configuração da Sessão

php
// session_start() automático
// Tempo de sessão: Padrão PHP
// Storage: Arquivos (padrão)
Configuração de Cores

css
:root {
  --finance-green: #0688bb;    /* Receitas */
  --finance-red: #4488ef;      /* Despesas */
  --finance-blue: #3b82f6;     /* Neutro */
  --finance-yellow: #0b97f5;   /* Alertas */
  --finance-purple: #5c6bf6;   /* Especial */
}
Configuração de API

javascript
const API_BASE = 'core/dashboardFinanceiro.php';
const LIMITE_PADRAO = 10;
const ATUALIZACAO_SALDO = 60000; // 1 minuto
🔌 API Endpoints

Estrutura Base

text
GET core/dashboardFinanceiro.php?acao=[ACAO]&[PARAMETROS]
Endpoints Disponíveis

Ação	Parâmetros	Retorno
saldo_caixa	-	{saldo_total: number}
contas_receber	status, limit, offset	Array<ContaReceber>
contas_pagar	status, limit	Array<ContaPagar>
adiantamentos_pendentes	tipo, limit, offset	Array<Adiantamento>
provisionamentos_categoria	periodo, categoria	Array<Provisionamento>
fluxo_caixa	periodo	{fluxo: Array<Dia>, ...}
grafico_contas_vencer	dias	{labels: [], receber: [], pagar: []}
evolucao_financeira	periodo	{meses: [], receitas: [], ...}
indicadores_financeiros	periodo	{receita_total, despesas_total, ...}
Exemplo de Requisição

javascript
// Buscar contas a receber
fetch('core/dashboardFinanceiro.php?acao=contas_receber&status=abertas&limit=10')
  .then(response => response.json())
  .then(data => console.log(data));
📁 Estrutura de Arquivos

text
dashboard-financeiro/
├── core/
│   ├── dashboardFinanceiro.php    # API Principal
│   ├── mysql.php                  # Conexão com BD
│   ├── header.php                 # Cabeçalho
│   ├── footer.php                 # Rodapé
│   ├── controleDePermissoes.php   # Controle de acesso
│   └── importacoes_js.php         # Scripts globais
├── home/
│   ├── home.sidebar.php           # Menu lateral
│   ├── home.topbar.php            # Barra superior
│   └── home.back.to.top.php       # Botão retorno
├── bin/
│   └── funcoes.bin.php            # Funções auxiliares
├── assets/
│   ├── css/                       # Estilos adicionais
│   ├── js/                        # Scripts específicos
│   └── images/                    # Imagens do sistema
├── index.php                      # Dashboard principal
├── signin.php                     # Login
└── README.md                      # Esta documentação
🔒 Segurança

Camadas de Proteção

Autenticação por Sessão
php
if (!isset($_SESSION['logado'])) {
    header('Location: signin');
    exit();
}
Sanitização de Output
php
echo htmlspecialchars($_SESSION['nome'], ENT_QUOTES, 'UTF-8');
Prepared Statements (no backend)
php
$stmt = $pdo->prepare("SELECT * FROM tabela WHERE id = ?");
$stmt->execute([$id]);
CORS Controlado
php
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
Validação de Inputs
javascript
// Validação no frontend
if (!data || data.length === 0) {
    showEmptyState();
}
Recomendações de Segurança

✅ Use HTTPS em produção
✅ Configure firewall no servidor
✅ Limite tentativas de login
✅ Mantenha logs de acesso
✅ Atualize regularmente
📱 Responsividade

Breakpoints

css
/* Desktop (>1400px) */
.graficos-container {
    grid-template-columns: repeat(2, 1fr);
}

/* Tablet (768px - 1400px) */
@media (max-width: 1400px) {
    .graficos-container {
        grid-template-columns: 1fr;
    }
}

/* Mobile (<576px) */
@media (max-width: 576px) {
    .company-header h3 {
        font-size: 1.5rem;
    }
    .finance-indicators {
        grid-template-columns: 1fr;
    }
}
Comportamento Responsivo

Desktop: 2-3 colunas, menus expandidos
Tablet: 1-2 colunas, menus compactos
Mobile: 1 coluna, navegação otimizada
🎨 Design System

Cores

Propósito	Cor	Código
Sucesso/Receita	Verde	#0688bb
Erro/Despesa	Vermelho	#4488ef
Informação	Azul	#3b82f6
Alerta	Amarelo	#0b97f5
Destaque	Roxo	#5c6bf6
Tipografia

Fonte Principal: System UI Stack
Tamanhos:

Títulos: 2.2rem (desktop), 1.5rem (mobile)
Texto: 1rem
Labels: 0.75rem
Valores: 1.5rem
Espaçamento

Padding padrão: 1rem
Margem entre cards: 1.5rem
Gap em grids: 1rem
Sombras e Efeitos

css
--card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
--card-hover-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
transition: all 0.3s ease;
🔄 Fluxo de Dados

Carregamento Inicial

Verificação de autenticação
Carregamento de dependências
Inicialização de gráficos vazios
Requisições paralelas para APIs
Renderização progressiva
Atualizações em Tempo Real

javascript
// Atualizações automáticas
setInterval(carregarSaldoTotal, 60000);     // 1 minuto
setInterval(carregarIndicadores, 300000);   // 5 minutos

// Atualizações sob demanda
function mudarPeriodo(periodo) {
    periodoAtual = periodo;
    recarregarTodosDados();
}
Gestão de Estado

javascript
const estado = {
    periodo: 'mes',
    graficos: {},
    contasReceber: {
        pagina: 0,
        dados: [],
        carregando: false
    },
    // ... outros estados
};
🐛 Solução de Problemas

Problemas Comuns

Gráficos não carregam

javascript
// Verifique:
// 1. Conexão com a internet
// 2. Console do navegador (F12)
// 3. Endpoints da API
Dados não atualizam

javascript
// Soluções:
// 1. Limpe cache do navegador
// 2. Verifique console.log()
// 3. Confirme sessão ativa
Layout quebrado

css
/* Verifique: */
/* 1. Console de erros CSS */
/* 2. Ordem de carregamento */
/* 3. Classes duplicadas */

📈 Performance

Otimizações Implementadas

✅ Lazy Loading: Carregamento progressivo
✅ Cache Local: Dados paginados
✅ Debouncing: Eventos de filtro
✅ Compressão: Assets minificados
✅ CDN: Bibliotecas externas
Métricas Alvo

Tempo de Carregamento: < 3s
Tempo de Interação: < 100ms
Uso de Memória: < 100MB
Requests Paralelos: 6-8 simultâneos