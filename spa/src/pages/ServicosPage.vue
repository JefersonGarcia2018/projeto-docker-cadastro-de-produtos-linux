<template>
  <q-page padding>
    <div class="q-gutter-md">
      <div class="row align-center q-mb-md">
        <div class="text-h4 text-primary">Gestão de Serviços</div>
      </div>

      <q-card class="q-pa-md shadow-1">
        <div class="text-h6 q-mb-md">{{ editando ? 'Editar Serviço' : 'Novo Serviço' }}</div>
        <q-form @submit="salvarServico" class="q-gutter-md">
          <div class="row q-col-gutter-md">
            <q-input v-model="form.descricao" label="Descrição (Ex: Troca de Óleo) *" outlined required class="col-12 col-md-5" />
            <q-input v-model="form.valor_padrao" label="Valor Padrão (R$) *" type="number" step="0.01" outlined required class="col-12 col-md-4" />
            <q-input v-model="form.tempo_estimado_minutos" label="Tempo Estimado (Minutos)" type="number" outlined class="col-12 col-md-3" />
          </div>
          
          <div class="row justify-end q-mt-md q-gutter-sm">
            <q-btn v-if="editando" label="Cancelar" color="grey" @click="cancelarEdicao" />
            <q-btn :label="editando ? 'Atualizar Serviço' : 'Adicionar Serviço'" color="primary" type="submit" />
          </div>
        </q-form>
      </q-card>

      <q-table title="Serviços Oferecidos" :rows="servicos" :columns="colunas" row-key="id" class="q-mt-lg">
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
const servicos = ref([])
const editando = ref(false)
const idOriginal = ref(null)

const form = ref({
  descricao: '',
  valor_padrao: null,
  tempo_estimado_minutos: null
})

const colunas = [
  { name: 'descricao', label: 'Descrição', field: 'descricao', align: 'left', sortable: true },
  { name: 'valor_padrao', label: 'Valor Padrão (R$)', field: 'valor_padrao', align: 'left' },
  { name: 'tempo_estimado_minutos', label: 'Duração (Min)', field: 'tempo_estimado_minutos', align: 'center' },
  { name: 'acoes', label: 'Ações', align: 'center' }
]

const carregarDados = async () => {
  try {
    const res = await api.get('/servicos')
    servicos.value = res.data
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Erro ao carregar serviços.' })
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
  form.value = { descricao: '', valor_padrao: null, tempo_estimado_minutos: null }
}

const salvarServico = async () => {
  try {
    if (editando.value) {
      await api.put(`/servicos/${idOriginal.value}`, form.value)
      $q.notify({ type: 'positive', message: 'Serviço atualizado!' })
    } else {
      await api.post('/servicos', form.value)
      $q.notify({ type: 'positive', message: 'Serviço cadastrado!' })
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
    await api.delete(`/servicos/${id}`)
    $q.notify({ type: 'info', message: 'Serviço excluído.' })
    carregarDados()
  } catch (e) {
    console.error(e)
    $q.notify({ type: 'negative', message: 'Não foi possível excluir o serviço.' })
  }
}

onMounted(carregarDados)
</script>
