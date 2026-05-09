# Projeto SaaS para Oficinas Mecânicas: Fundação Multi-Tenant e Autenticação

Para transformarmos o projeto em um SaaS, o ponto de partida ideal é a fundação de segurança e isolamento de dados. Antes de criarmos as telas de Ordens de Serviço (OS), Veículos ou Serviços, precisamos de uma estrutura que garanta que o usuário só tenha acesso aos dados da própria oficina.

## User Review Required

> [!WARNING]
> Esse plano de implementação fará alterações nas **migrations** já existentes e na estrutura do banco de dados, o que limpará os registros atuais quando rodarmos os comandos de banco de dados (`php artisan migrate:fresh`). Isso é esperado no cenário atual?

> [!CAUTION]
> A API a partir de agora exigirá um token de Autenticação, o que significa que o frontend precisará primeiro de uma tela de "Login" para obter o acesso, caso contrário receberão o status `401 Unauthorized`.

---

## Proposed Changes

A fundação começará com alterações principalmente no **Backend** (Laravel) e os ajustes iniciais no **Frontend** (Quasar) para lidar com autenticação.

### Backend - Migrations e Banco de Dados

Criação dos modelos e migrações para gerenciar o isolamento de informações.

#### [NEW] `api/database/migrations/xxxx_xx_xx_xxxxxx_create_tenants_table.php`
- Migration para a tabela `tenants`. Conterá dados básicos da Oficina (id, razao_social, cnpj, created_at, updated_at).

#### [MODIFY] `api/database/migrations/0001_01_01_000000_create_users_table.php`
- Adição da coluna `tenant_id` como uma chave estrangeira nas tabelas de usuários, para conectá-los a uma oficina.

#### [MODIFY] `api/database/migrations/2026_04_05_205842_create_produtos_table.php`
- Adição da coluna `tenant_id` nas tabelas de produtos para garantir que a peça/produto pertença somente àquela oficina.

---

### Backend - Models e Core Business

Implementando a regra nativa de isolamento de dados no Laravel utilizando `Global Scopes` e Traits. Em vez de adicionar um "where tenant" em todo lugar no código, isso ficará protegido na configuração profunda (core).

#### [NEW] `api/app/Models/Tenant.php`
- Model representando a Oficina.

#### [NEW] `api/app/Models/Scopes/TenantScope.php`
- Criação de um Global Scope do Laravel. Essa regra injetará automaticamente um `where tenant_id = auth()->user()->tenant_id` em consultas de banco feitas por Models usando a trait abaixo.

#### [NEW] `api/app/Traits/BelongsToTenant.php`
- Um Trait simples que liga o Model atual ao `TenantScope` e preenche (`booting`) magicamente o `tenant_id` na hora da criação com base no usuário logado.

#### [MODIFY] `api/app/Models/User.php` e `api/app/Models/Produto.php`
- Adição do Trait `BelongsToTenant` para blindá-los na regra de negócio.

---

### Backend - Controladores e Rotas

Adicionar suporte ao Login/Setup.

#### [NEW] `api/app/Http/Controllers/AuthController.php`
- Controlador que cuidará do método de **Login** e **Register** (Para a mecânica se cadastrar, criando assim o seu `Tenant` e o primeiro `User` atrelado a esse tenant em uma única transação). Retornará o Token JWT do Sanctum.

#### [MODIFY] `api/routes/api.php`
- Proteção das rotas do `ProdutoController` com o middleware `auth:sanctum`.
- Criação das rotas públicas de login e registro em '/auth/login' e '/auth/register'.

---

### Frontend - Autenticação Básica (Quasar Vue)

O front-end precisará ser isolado em áreas públicas e privadas.

#### [NEW] `spa/src/stores/auth.js`
- Estado via Pinia para gerenciar o Token do usuário logado e os dados dele. O Axios global (boot do Quasar) utilizará este Store para enviar o Token via cabeçalho `Authorization: Bearer <Token>`.

#### [NEW] `spa/src/pages/auth/LoginPage.vue` e `RegisterPage.vue`
- Telas iniciais e simples para quem quer logar ou registrar uma nova Oficina (SaaS).

#### [MODIFY] `spa/src/router/routes.js`
- Rotas para lidar com telas públicas e privadas (middleware local usando *Vue Router Navigation Guards*).

## Open Questions

> [!IMPORTANT]
> 1. Posso assumir a criação da tela visual de **Login / Cadastro da Oficina** usando o padrão estético atual do seu projeto (Quasar padrão)?
> 2. Como esse é um projeto local e iremos modificar a base estrutural, rodar o comando `migrate:fresh` vai destruir o banco atual e recriar. Você tem dados importantes ali ou podemos prosseguir com o fresh?

## Verification Plan

### Manual Verification
1. Verificarei pela tela de Registro (Mock via Curl ou visual) a criação simultânea da Oficina (Tenant) e do seu novo responsável.
2. Com o Login na tela do Quasar garantido, farei o teste acessando novamente os Produtos e criando um `Produto A`.
3. Criarei visualmente um segundo registro/tenant para o usuário `Y`, na qual ao logar, validarei se o `Produto A` do usuário `X` NÃO está sendo exibido, confirmando a fundação do Multi-Tenancy.
