<template>
  <q-page padding>
    <div class="q-gutter-md">
      <div class="row align-center q-mb-md">
        <div class="text-h4 text-primary">Gestão de Clientes</div>
      </div>

      <q-card class="q-pa-md shadow-1">
        <div class="text-h6 q-mb-md">{{ editando ? 'Editar Cliente' : 'Novo Cliente' }}</div>
        <q-form @submit="salvarCliente" class="q-gutter-md">
          <div class="row q-col-gutter-md">
            <q-input v-model="form.nome" label="Nome do Cliente *" outlined required class="col-12 col-md-6" />
            <q-input v-model="form.cpf" label="CPF / CNPJ" outlined class="col-12 col-md-6" />
            <q-input v-model="form.email" label="E-mail" type="email" outlined class="col-12 col-md-4" />
            <q-input v-model="form.telefone" label="Telefone" outlined class="col-12 col-md-4" />
            <q-input v-model="form.endereco" label="Endereço" outlined class="col-12 col-md-4" />
          </div>
          
          <div class="row justify-end q-mt-md q-gutter-sm">
            <q-btn v-if="editando" label="Cancelar" color="grey" @click="cancelarEdicao" />
            <q-btn :label="editando ? 'Atualizar Cliente' : 'Adicionar Cliente'" color="primary" type="submit" />
          </div>
        </q-form>
      </q-card>

      <q-table title="Clientes Cadastrados" :rows="clientes" :columns="colunas" row-key="id" class="q-mt-lg">
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
const clientes = ref([])
const editando = ref(false)
const idOriginal = ref(null)

const form = ref({
  nome: '',
  cpf: '',
  email: '',
  telefone: '',
  endereco: ''
})

const colunas = [
  { name: 'nome', label: 'Nome', field: 'nome', align: 'left', sortable: true },
  { name: 'telefone', label: 'Telefone', field: 'telefone', align: 'left' },
  { name: 'email', label: 'E-mail', field: 'email', align: 'left' },
  { name: 'acoes', label: 'Ações', align: 'center' }
]

const carregarDados = async () => {
  try {
    const res = await api.get('/clientes')
     clientes.value = res.data
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Erro ao carregar clientes.' })
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
  form.value = { nome: '', cpf: '', email: '', telefone: '', endereco: '' }
}

const salvarCliente = async () => {
  try {
    if (editando.value) {
      await api.put(`/clientes/${idOriginal.value}`, form.value)
      $q.notify({ type: 'positive', message: 'Cliente atualizado!' })
    } else {
      await api.post('/clientes', form.value)
      $q.notify({ type: 'positive', message: 'Cliente cadastrado!' })
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
    await api.delete(`/clientes/${id}`)
    $q.notify({ type: 'info', message: 'Cliente excluído.' })
    carregarDados()
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Não foi possível excluir o cliente.' })
  }
}

onMounted(carregarDados)
</script>
