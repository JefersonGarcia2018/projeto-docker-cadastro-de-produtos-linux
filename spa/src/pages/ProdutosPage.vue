<template>
  <q-page padding>
    <div class="q-gutter-md">
      <div class="row align-center q-mb-md">
        <div class="text-h4 text-primary">Gestão de Produtos / Peças</div>
      </div>

      <q-card class="q-pa-md shadow-1">
        <div class="text-h6 q-mb-md">{{ editando ? 'Editar Produto' : 'Novo Produto' }}</div>
        <q-form @submit.prevent="salvarProduto" class="q-gutter-md">
          <div class="row q-col-gutter-md">
            <q-input v-model="form.codigo" label="Código da Peça (SKU)" outlined class="col-12 col-md-3" />
            <q-input v-model="form.nome" label="Nome do Produto *" outlined required class="col-12 col-md-5" />
            <q-input v-model="form.preco" label="Preço (R$) *" type="number" step="0.01" outlined required class="col-12 col-md-2" />
            <q-input v-model="form.estoque" label="Qtd Estoque" type="number" outlined class="col-12 col-md-2" />
          </div>
          
          <div class="row justify-end q-mt-md q-gutter-sm">
            <q-btn v-if="editando" label="Cancelar" color="grey" @click="cancelarEdicao" />
            <q-btn :label="editando ? 'Atualizar Produto' : 'Adicionar Produto'" color="primary" type="submit" />
          </div>
        </q-form>
      </q-card>

      <q-table title="Estoque de Produtos" :rows="produtos" :columns="colunas" row-key="id" class="q-mt-lg">
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
const produtos = ref([])
const editando = ref(false)
const idOriginal = ref(null)

const form = ref({
  codigo: '',
  nome: '',
  preco: null,
  estoque: 0
})

const colunas = [
  { name: 'codigo', label: 'Código', field: 'codigo', align: 'left', sortable: true },
  { name: 'nome', label: 'Nome', field: 'nome', align: 'left', sortable: true },
  { name: 'preco', label: 'Preço (R$)', field: 'preco', align: 'left' },
  { name: 'estoque', label: 'Estoque', field: 'estoque', align: 'center' },
  { name: 'acoes', label: 'Ações', align: 'center' }
]

const carregarDados = async () => {
  try {
    const res = await api.get('/produtos')
    produtos.value = res.data
  } catch (e) {
    if (e.response?.status !== 401) {
      $q.notify({ type: 'negative', message: 'Erro ao carregar produtos.' })
    }
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
  form.value = { codigo: '', nome: '', preco: null, estoque: 0 }
}

const salvarProduto = async () => {
  try {
    if (editando.value) {
      await api.put(`/produtos/${idOriginal.value}`, form.value)
      $q.notify({ type: 'positive', message: 'Produto atualizado!' })
    } else {
      await api.post('/produtos', form.value)
      $q.notify({ type: 'positive', message: 'Produto cadastrado!' })
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
    await api.delete(`/produtos/${id}`)
    $q.notify({ type: 'info', message: 'Produto excluído.' })
    carregarDados()
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Não foi possível excluir o produto.' })
  }
}

onMounted(carregarDados)
</script>