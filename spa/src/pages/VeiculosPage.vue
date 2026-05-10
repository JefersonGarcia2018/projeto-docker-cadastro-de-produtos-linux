<template>
  <q-page padding>
    <div class="q-gutter-md">
      <div class="row align-center q-mb-md">
        <div class="text-h4 text-primary">Gestão de Veículos</div>
      </div>

      <q-card class="q-pa-md shadow-1">
        <div class="text-h6 q-mb-md">{{ editando ? 'Editar Veículo' : 'Novo Veículo' }}</div>
        <q-form @submit="salvarVeiculo" class="q-gutter-md">
          <div class="row q-col-gutter-md">
            <q-select 
              v-model="form.cliente_id" 
              :options="clientes" 
              option-value="id" 
              option-label="nome" 
              emit-value 
              map-options 
              label="Cliente (Proprietário) *" 
              outlined 
              required 
              class="col-12 col-md-4" 
            />
            <q-input v-model="form.placa" label="Placa *" outlined required class="col-12 col-md-2" />
            <q-input v-model="form.marca" label="Marca" outlined class="col-12 col-md-3" />
            <q-input v-model="form.modelo" label="Modelo" outlined class="col-12 col-md-3" />
            <q-input v-model="form.ano" label="Ano" type="number" outlined class="col-12 col-md-2" />
            <q-input v-model="form.cor" label="Cor" outlined class="col-12 col-md-2" />
          </div>
          
          <div class="row justify-end q-mt-md q-gutter-sm">
            <q-btn v-if="editando" label="Cancelar" color="grey" @click="cancelarEdicao" />
            <q-btn :label="editando ? 'Atualizar Veículo' : 'Adicionar Veículo'" color="primary" type="submit" />
          </div>
        </q-form>
      </q-card>

      <q-table title="Frota de Clientes" :rows="veiculos" :columns="colunas" row-key="id" class="q-mt-lg">
        <template v-slot:body-cell-cliente="props">
          <q-td :props="props">
            {{ props.row.cliente?.nome }}
          </q-td>
        </template>
        <template v-slot:body-cell-acoes="props">
          <q-td :props="props" class="q-gutter-xs">
            <q-btn icon="edit" color="blue" flat dense @click="prepararEdicao(props.row)" />
            <q-btn icon="delete" color="negative" flat dense @click="excluir(props.row.id)" />
          </q-td>
        </template>
      </q-table>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'

const $q = useQuasar()
const veiculos = ref([])
const clientes = ref([])
const editando = ref(false)
const idOriginal = ref(null)

const form = ref({
  cliente_id: null,
  placa: '',
  marca: '',
  modelo: '',
  ano: null,
  cor: ''
})

const colunas = [
  { name: 'placa', label: 'Placa', field: 'placa', align: 'left', sortable: true },
  { name: 'cliente', label: 'Proprietário', field: row => row.cliente?.nome, align: 'left', sortable: true },
  { name: 'marca', label: 'Marca', field: 'marca', align: 'left' },
  { name: 'modelo', label: 'Modelo', field: 'modelo', align: 'left' },
  { name: 'acoes', label: 'Ações', align: 'center' }
]

const carregarClientes = async () => {
  try {
    const res = await api.get('/clientes')
    clientes.value = res.data
  } catch (e) {
    console.error(e)
  }
}

const carregarDados = async () => {
  try {
    const res = await api.get('/veiculos')
    veiculos.value = res.data
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Erro ao carregar veículos.' })
  }
}

const prepararEdicao = (item) => {
  editando.value = true
  idOriginal.value = item.id
  form.value = { ...item }
}

const cancelarEdicao = () => {
  editando.value = false
  idOriginal.value = null
  form.value = { cliente_id: null, placa: '', marca: '', modelo: '', ano: null, cor: '' }
}

const salvarVeiculo = async () => {
  try {
    if (editando.value) {
      await api.put(`/veiculos/${idOriginal.value}`, form.value)
      $q.notify({ type: 'positive', message: 'Veículo atualizado!' })
    } else {
      await api.post('/veiculos', form.value)
      $q.notify({ type: 'positive', message: 'Veículo cadastrado!' })
    }
    cancelarEdicao()
    carregarDados()
  } catch (error) {
    console.error(error)
    $q.notify({ type: 'negative', message: 'Erro ao salvar os dados.' })
  }
}

const excluir = async (id) => {
  try {
    await api.delete(`/veiculos/${id}`)
    $q.notify({ type: 'info', message: 'Veículo excluído.' })
    carregarDados()
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Não foi possível excluir o veículo.' })
  }
}

onMounted(() => {
  carregarClientes()
  carregarDados()
})
</script>
