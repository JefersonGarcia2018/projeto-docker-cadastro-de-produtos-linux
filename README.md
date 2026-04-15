# 📦 Full Stack SaaS: Laravel 13 + Quasar (Vue 3) + Docker

Este é um projeto **SaaS (Software as a Service) Multi-Tenant desenvolvido para Oficinas Mecânicas**. Arquitetado com separação perfeita **Cliente-Servidor (API REST + SPA)**, possui foco de máxima segurança, provendo isolamento de dados lógico automático entre diferentes oficinas usando a mesma infraestrutura, apoiando-se no que há de mais moderno na linguagem PHP e Javascript.

## 🛠️ Tecnologias e Ferramentas

### **Backend (API)**
* **Framework:** Laravel 13
* **Linguagem:** PHP 8.4 (FPM)
* **Autenticação e Segurança:** Laravel Sanctum (Bearer Tokens)
* **Gerenciador de Dependências:** Composer
* **Estrutura Core:** Eloquent Global Scopes e Traits dinâmicas.

### **Frontend (SPA)**
* **Framework:** Vue.js 3
* **Interface UI:** Quasar Framework v2 (Vite)
* **Gestão de Estados Globais:** Pinia
* **Comunicação e Roteamento:** Axios Interceptors e Vue Router c/ Navigation Guards

### **Infraestrutura**
* **Orquestração:** Docker & Docker Compose
* **Banco de Dados:** MySQL 8.0
* **Ambiente OS:** Linux/Ubuntu

-----

## 🚀 Como Rodar o Projeto

### **1. Pré-requisitos**
Certifique-se de ter instalado em sua máquina:
* [Docker](https://docs.docker.com/get-docker/)
* [Docker Compose](https://docs.docker.com/compose/install/)

### **2. Instalação**
1. **Clonar o Repositório:**
    ```bash
    git clone https://github.com/JefersonGarcia2018/projeto-docker-cadastro-de-produtos-linux.git
    cd projeto-docker-cadastro-de-produtos-linux
    ```

2. **Configurar Variáveis de Ambiente:**
    * Entre na pasta `api/` e copie o arquivo de exemplo:
      ```bash
      cp .env.example .env
      ```
    * No arquivo `.env`, garanta que as configurações de banco estejam assim:
      ```env
      DB_CONNECTION=mysql
      DB_HOST=db
      DB_PORT=3306
      DB_DATABASE=laravel_db
      DB_USERNAME=root
      DB_PASSWORD=root
      ```

3. **Subir os Contêiners (Modo Preparação):**
    No arquivo `docker-compose.yml`, ajuste temporariamente o `command` dos serviços `api` e `spa` para `tail -f /dev/null` e suba os contêineres:
    ```bash
    docker compose up -d --build
    ```

4. **Instalar Dependências e Migrar Banco:**
    ```bash
    # Backend
    docker exec -it projeto-api composer install
    docker exec -it projeto-api php artisan key:generate
    docker exec -it projeto-api php artisan migrate:fresh

    # Frontend
    docker exec -it projeto-spa npm install
    ```

5. **Subir o Ambiente Completo:**
    No arquivo `docker-compose.yml`, volte os comandos oficiais (`php artisan serve` e `npx quasar dev`), pare os contêineres e recarregue-os:
    ```bash
    docker compose stop
    docker compose up -d
    ```

## 🌐 Acesso ao Ambiente

Após subir os contêiners, a plataforma e a API estarão ativas:
* **Frontend Institucional do Sistema (Quasar):** [http://localhost:9000](http://localhost:9000)
* **Backend Core (Laravel API):** [http://localhost:8000](http://localhost:8000)
* **Banco de Dados (MySQL):** Porta `3306` local cruzada

-----

## 📝 Estado Atual e Funcionalidades

A plataforma evoluiu da prova de conceito de "CRUD Simples" para um sistema Multilocatário maduro de gerenciamento automotivo. Estão integrados e testados as seguintes esferas:

### **Concluído até aqui:**
* **Módulo de Autenticação & Tenancy:** Rotinas completas de Login e Registro. Toda conta criada gera uma Unidade isolada de Oficina. Todas as consultas posteriores têm o ID do inquilino chumbado nas regras sistêmicas de banco, não mesclando dados.
* **Dashboard em Tempo Real:** Tela de entrada (Painel) contendo Cards sumarizados de volume transacional da Unidade/Oficina.
* **Módulo de Clientes:** CRUD complexo registrando e listando portadores de carros.
* **Módulo de Veículos:** Controle integrado da frota, atrelando modelos e placas a um dono (chave estrangeira na tabela de Clientes).
* **Catálogo de Mão-de-obra:** Gestão padronizada de serviços (precificação base e estimativa de tempo) ofertados pela sua loja.
* **Estoque de Peças (Produtos):** Inventário contendo codificação livre de produtos e controle quantitativo em valor.

### **🚀 Futuras Funcionalidades (Roadmap)**
O alicerce está selado. O projeto avançará para implementar o faturamento visual e estrutural através do seguinte roteiro:

1. **Gestor de Ordens de Serviço (OS):** O núcleo final do app SaaS. Capacidade de atrelar Clientes aos Veículos selecionados num "Ticket" temporário, somando as Peças da OS contra a Mão de obra para precificar relatórios de cobrança.
2. **Mudanças de Status da OS:** Ciclo de "Em Orçamento -> Aprovada -> Em Execução -> Finalizada".
3. **Módulo de Impressão (PDF):** Relatórios unificados da Ordem de Serviço de forma elegante e formatada.
4. **Resumo Financeiro:** Incorporação de receita total das OS faturadas dentro do Dashboard Gráfico.

-----

**Desenvolvido por:** Jeferson Garcia 🚀