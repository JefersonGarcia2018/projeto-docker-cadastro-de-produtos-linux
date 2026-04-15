# Módulo Base da Oficina: Clientes, Veículos e Serviços

Com a fundação Multi-Tenant e Autenticação funcionando perfeitamente, o próximo passo lógico é construir o cadastro das entidades que darão vida à oficina mecânica. 
Sem Clientes, Veículos e os Serviços(Mão de obra), não podemos gerar uma Ordem de Serviço (OS).

## User Review Required

Nenhuma decisão crítica que afete ou destrua o banco atual será tomada. Apenas criaremos novas tabelas e interfaces.

## Proposed Changes

Abaixo estão os 3 pilares que definiremos nesta etapa, tanto no Backend quanto no Frontend.

### Backend (Laravel API)

#### [NEW] Modelos e Migrations
Criaremos as migrações e classes Eloquent na seguinte ordem (respeitando relacionamentos):
1. **`Cliente`**: Tabela `clientes` (nome, cpf, email, telefone, endereco). Estará vinculada à Oficina (`tenant_id`).
2. **`Veiculo`**: Tabela `veiculos` (placa, marca, modelo, ano, cor). Estará vinculada a um `cliente_id` e também ao `tenant_id`.
3. **`Servico`**: Tabela `servicos` (descricao, valor_padrao, tempo_estimado_minutos). Será o catálogo de mão-de-obra da Oficina. Vinculada ao `tenant_id`.

Todos esses modelos receberão a Trait `BelongsToTenant` para garantir a segurança dos dados.

#### [NEW] Controllers e Rotas
4. **Controladores**: `ClienteController`, `VeiculoController`, `ServicoController` proverão métodos `index`, `store`, `show`, `update` e `destroy`.
5. **Rotas**: Adicionadas no arquivo `api.php` dentro do grupo restrito do Sanctum (ex: `Route::apiResource('clientes', ClienteController::class)`).

---

### Frontend (Vue/Quasar SPA)

#### [NEW] Páginas e CRUDs
Desenvolveremos as interfaces para a operação destas entidades no painel interno.

1. **`spa/src/pages/ClientesPage.vue`**: Uma `q-table` com formulário de cadastro, similar a de produtos, focada em registrar os donos dos carros.
2. **`spa/src/pages/VeiculosPage.vue`**: Tabela focada na listagem de carros, onde ao cadastrar, o usuário buscará (via *select*) a qual cliente aquele veículo pertence.
3. **`spa/src/pages/ServicosPage.vue`**: Tabela com foco no gerenciamento da Mão-de-Obra ofertada pela oficina.

#### [MODIFY] Menu e Roteamento
- Atualizar o `MainLayout.vue` para incluir esses 3 novos atalhos no menu lateral (Drawer).
- Registrar essas novas rotas dentro do arquivo `router/routes.js`.

## Open Questions

> [!IMPORTANT]
> 1. Para os Veículos, você quer exigir um vínculo obrigatório com um *Cliente*, ou permite registrar veículos soltos (avulsos) na oficina para depois atribuir o dono? (O plano padrão assumirá que o *Cliente é obrigatório* para um veículo).
> 2. Ao invés de uma página separada só para cadastrar veículos, acha interessante, futuramente, podermos adicionar veículos do cliente "Por dentro" de uma Aba na tela do próprio Cliente? O plano atual cria uma página independente simples para acelerarmos a entrega, algo que podemos unificar depois.

## Verification Plan

### Testes Manuais
- Certificar-se que migrations rodam limpas via comando Docker.
- Entrar no front e cadastrar um Cliente fictício (ex: "Jeferson").
- Cadastrar um veículo com placa "ABC-1234" e vinculá-lo ao "Jeferson".
- Acessar o sistema com a Oficina B e averiguar que ela não tem acesso ao "Jeferson".
