<template>
  <q-page padding>
    <div class="row items-center q-mb-lg">
      <div class="text-h4 text-primary">Dashboard da Oficina</div>
      <q-space />
      <div class="text-subtitle1 text-grey-7" v-if="authStore.tenant">
        Unidade: {{ authStore.tenant.nome }}
      </div>
    </div>

    <!-- Seção de Métricas (Cards) -->
    <div class="row q-col-gutter-md">
      <!-- Card Clientes -->
      <div class="col-12 col-sm-6 col-md-3">
        <q-card class="bg-primary text-white shadow-2">
          <q-card-section class="q-pb-none">
            <div class="text-h6">Clientes</div>
          </q-card-section>
          <q-card-section class="flex flex-center">
            <div class="text-h3 text-weight-bold">{{ metrics.clientes_count }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat icon="arrow_forward" label="Ver todos" to="/clientes" />
          </q-card-actions>
        </q-card>
      </div>

      <!-- Card Veículos -->
      <div class="col-12 col-sm-6 col-md-3">
        <q-card class="bg-secondary text-white shadow-2">
          <q-card-section class="q-pb-none">
            <div class="text-h6">Veículos</div>
          </q-card-section>
          <q-card-section class="flex flex-center">
            <div class="text-h3 text-weight-bold">{{ metrics.veiculos_count }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat icon="arrow_forward" label="Ver todos" to="/veiculos" />
          </q-card-actions>
        </q-card>
      </div>

      <!-- Card Serviços -->
      <div class="col-12 col-sm-6 col-md-3">
        <q-card class="bg-accent text-white shadow-2">
          <q-card-section class="q-pb-none">
            <div class="text-h6">Mão-de-Obra / Serviços</div>
          </q-card-section>
          <q-card-section class="flex flex-center">
            <div class="text-h3 text-weight-bold">{{ metrics.servicos_count }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat icon="arrow_forward" label="Ver todos" to="/servicos" />
          </q-card-actions>
        </q-card>
      </div>

      <!-- Card Produtos / Peças -->
      <div class="col-12 col-sm-6 col-md-3">
        <q-card class="bg-purple text-white shadow-2">
          <q-card-section class="q-pb-none">
            <div class="text-h6">Peças no Estoque</div>
          </q-card-section>
          <q-card-section class="flex flex-center">
            <div class="text-h3 text-weight-bold">{{ metrics.produtos_count }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat icon="arrow_forward" label="Ver todas" to="/produtos" />
          </q-card-actions>
        </q-card>
      </div>
    </div>

    <!-- Espaço para futuros Gráficos / Tabela de Ordens de Serviço -->
    <div class="row q-mt-lg">
      <div class="col-12">
        <q-card class="shadow-1">
          <q-card-section>
            <div class="text-h6 text-grey-8">Próximos Passos Administrativos</div>
          </q-card-section>
          <q-card-section>
            <p>O módulo de <strong>Ordens de Serviço (OS)</strong> será construído a seguir. Nele, agruparemos os Clientes, seus Veículos, as Peças utilizadas e a Mão-de-Obra orçada para gerar faturamento e controle de caixa.</p>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from 'boot/axios'
import { useAuthStore } from 'stores/auth'

const authStore = useAuthStore()

const metrics = ref({
  clientes_count: 0,
  veiculos_count: 0,
  servicos_count: 0,
  produtos_count: 0,
})

const carregarDashboard = async () => {
  try {
    const res = await api.get('/dashboard')
    metrics.value = res.data
  } catch (e) {
    if (e.response?.status !== 401) {
      console.error('Erro ao carregar os dados do dashboard', e)
    }
  }
}

onMounted(() => {
  carregarDashboard()
})
</script>