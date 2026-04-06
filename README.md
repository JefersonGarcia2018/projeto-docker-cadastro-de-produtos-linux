# 📦 Full Stack Project: Laravel 13 + Quasar (Vue 3) + Docker

Este é um projeto de arquitetura **Cliente-Servidor Desacoplada**, desenvolvido com foco em alta performance e isolamento de ambiente utilizando containers. O sistema consiste em uma API robusta e um SPA (Single Page Application) moderno.

## 🛠️ Tecnologias e Ferramentas

### **Backend (API)**

  * **Framework:** Laravel 13
  * **Linguagem:** PHP 8.4 (FPM)
  * **Autenticação/API:** Laravel Sanctum
  * **Gerenciador de Dependências:** Composer

### **Frontend (SPA)**

  * **Framework:** Vue.js 3
  * **Interface:** Quasar Framework v2 (Vite)
  * **Comunicação:** Axios
  * **Linguagem:** JavaScript / Node.js 22

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

1.  **Clonar o Repositório:**

    ```bash
    git clone https://github.com/JefersonGarcia2018/projeto-docker-cadastro-de-produtos-linux.git
    cd projeto_simples
    ```

2.  **Configurar Variáveis de Ambiente:**

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

3.  **Subir os Containers:**

    ```bash
    docker compose up -d --build
    ```

4.  **Instalar Dependências e Migrar Banco:**

    ```bash
    # Backend
    docker exec -it projeto-api composer install
    docker exec -it projeto-api php artisan key:generate
    docker exec -it projeto-api php artisan migrate

    # Frontend
    docker exec -it projeto-spa npm install
    ```

-----

## 📝 Sobre o CRUD de Produtos

O projeto inclui um módulo funcional de **Cadastro de Produtos**, demonstrando a integração completa entre as camadas.

### **Funcionalidades implementadas:**

  * **Listagem (Read):** Exibição de produtos em uma `q-table` do Quasar com atualização reativa.
  * **Criação (Create):** Formulário dinâmico que envia dados via `POST` para a API.
  * **Edição (Update):** Recuperação de dados existentes e atualização via `PUT`.
  * **Exclusão (Delete):** Remoção lógica e física de registros via `DELETE`.

### **Endpoints da API:**

  * `GET /api/produtos` - Lista todos os produtos.
  * `POST /api/produtos` - Salva um novo produto.
  * `PUT /api/produtos/{id}` - Atualiza um produto existente.
  * `DELETE /api/produtos/{id}` - Remove um produto.

-----

## 🌐 Acesso ao Ambiente

Após subir os containers, as aplicações estarão disponíveis em:

  * **Frontend (Quasar):** [http://localhost:9000](https://www.google.com/search?q=http://localhost:9000)
  * **Backend (Laravel):** [http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)
  * **Banco de Dados (MySQL):** Porta `3306`

-----

## 🔧 Comandos Úteis

  * **Parar containers:** `docker compose stop`
  * **Ver logs do sistema:** `docker compose logs -f`
  * **Acessar terminal do PHP:** `docker exec -it projeto-api bash`
  * **Limpar cache do Laravel:** `docker exec -it projeto-api php artisan optimize:clear`

-----

**Desenvolvido por:** Jeferson Garcia 🚀