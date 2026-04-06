<template>
  <q-page padding>
    <div class="q-gutter-md">

      <q-card-section class="row q-gutter-sm">
        <q-input v-model="form.nome" label="Nome" class="col" />
        <q-input v-model="form.preco" label="Preço" type="number" class="col" />

        <q-btn :label="editando ? 'Atualizar' : 'Adicionar'" :color="editando ? 'orange' : 'primary'"
          @click="salvarProduto" />
        <q-btn v-if="editando" label="Cancelar" flat @click="cancelarEdicao" />
      </q-card-section>

      <q-table title="Meus Produtos" :rows="produtos" :columns="colunas" row-key="id">

        <template v-slot:body-cell-acoes="props">
          <q-td :props="props" class="q-gutter-xs">
            <q-btn icon="edit" color="blue" flat @click="prepararEdicao(props.row)" />
            <q-btn icon="delete" color="negative" flat @click="excluir(props.row.id)" />
          </q-td>
        </template>

      </q-table>
    </div>
  </q-page>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { api } from 'boot/axios'

const produtos = ref([])
const editando = ref(false)
const produtoIdOriginal = ref(null)

const form = ref({
  nome: '',
  preco: 0,
  estoque: 0
})

const colunas = [
  { name: 'nome', label: 'Nome', field: 'nome', align: 'left' },
  { name: 'preco', label: 'Preço', field: 'preco' },
  { name: 'acoes', label: 'Ações', align: 'center' }
]

const carregarProdutos = async () => {
  const res = await api.get('/produtos')
  produtos.value = res.data
}

// Função para carregar os dados no formulário ao clicar em Editar
const prepararEdicao = (produto) => {
  editando.value = true
  produtoIdOriginal.value = produto.id
  form.value = { ...produto } // Copia os dados para o formulário
}

const cancelarEdicao = () => {
  editando.value = false
  produtoIdOriginal.value = null
  form.value = { nome: '', preco: 0, estoque: 0 }
}

const salvarProduto = async () => {
  try {
    if (editando.value) {
      // Rota de UPDATE (PUT/PATCH)
      await api.put(`/produtos/${produtoIdOriginal.value}`, form.value)
    } else {
      // Rota de CREATE (POST)
      await api.post('/produtos', form.value)
    }

    cancelarEdicao()
    carregarProdutos()
  } catch (error) {
    console.error('Erro ao salvar:', error)
  }
}

const excluir = async (id) => {
  await api.delete(`/produtos/${id}`)
  carregarProdutos()
}

onMounted(carregarProdutos)
</script>