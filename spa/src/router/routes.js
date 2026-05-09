const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      { path: '', component: () => import('pages/IndexPage.vue') },
      { path: 'produtos', component: () => import('pages/ProdutosPage.vue') },
      { path: 'clientes', component: () => import('pages/ClientesPage.vue') },
      { path: 'veiculos', component: () => import('pages/VeiculosPage.vue') },
      { path: 'servicos', component: () => import('pages/ServicosPage.vue') }
    ],
  },
  {
    path: '/auth',
    component: () => import('layouts/BlankLayout.vue'),
    children: [
      { path: 'login', alias: '/login', component: () => import('pages/auth/LoginPage.vue') },
      { path: 'register', alias: '/register', component: () => import('pages/auth/RegisterPage.vue') }
    ]
  },
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
]

export default routes
