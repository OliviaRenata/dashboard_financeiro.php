Dashboard Financeiro Empresarial
Descrição
Dashboard financeiro completo desenvolvido em PHP e JavaScript para gestão financeira empresarial. Sistema web responsivo que fornece uma visão 360° da saúde financeira da empresa com dados em tempo real.

Funcionalidades Principais
Visão Geral Financeira
Saldo Total em tempo real

Indicadores Chave: Receita, Despesas, Lucro Líquido e Margem

Gráficos Interativos:

Fluxo de Caixa (30 dias)

Contas a Vencer (15 dias)

Evolução Financeira (12 meses)

Gerenciamento de Contas
Contas a Receber: Lista de clientes com valores pendentes

Paginação: 10 itens por vez com botão "Ver mais"

Status: Em aberto/Pago

Ordenação: Mais recentes primeiro

Contas a Pagar: Fornecedores com vencimentos

Status: Quitada/Aberta

Valores formatados automaticamente

Adiantamentos Pendentes
Sistema de paginação server-side

Busca 10 registros por vez do servidor

Acumulação progressiva com controle de visibilidade

Formatação: Valores em R$ com cores indicativas por status

Provisionamentos
Categorização: Despesas vs Receitas

Comparativo: Previsto vs Realizado

Filtro por período (mês atual)

Tecnologias Utilizadas
Frontend
HTML5, CSS3 com design moderno

JavaScript ES6+ com Chart.js para gráficos

Interface totalmente responsiva

Animações CSS para melhor UX

Backend
PHP 7.4+ com sessões

API RESTful customizada

MySQL para armazenamento de dados

Arquitetura
Estrutura de Arquivos
text
/
├── core/
│   ├── mysql.php            # Conexão com banco de dados
│   ├── header.php           # Cabeçalho padrão
│   ├── controleDePermissoes.php # Controle de acesso
│   └── dashboardFinanceiro.php # API principal
├── home/
│   ├── home.sidebar.php     # Menu lateral
│   ├── home.topbar.php      # Barra superior
│   └── home.back.to.top.php # Botão retorno
├── bin/
│   └── funcoes.bin.php      # Funções auxiliares
└── index.php                # Página principal
Fluxo de Funcionamento
Verificação de sessão do usuário

Carregamento de dados da empresa

Renderização do layout base

Carregamento assíncrono de dados via JavaScript

Atualização dinâmica dos componentes

Instalação
Pré-requisitos
Servidor web (Apache/Nginx)

PHP 7.4 ou superior

MySQL 5.7 ou superior

Git

Passos de Instalação
