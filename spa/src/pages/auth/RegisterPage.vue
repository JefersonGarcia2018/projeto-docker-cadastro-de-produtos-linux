<template>
  <q-page class="flex flex-center bg-grey-2">
    <q-card class="q-pa-md shadow-2 my_card" style="width: 450px; max-width: 90vw;">
      <q-card-section class="text-center">
        <div class="text-h5 text-weight-bold text-primary">SaaS Oficina</div>
        <div class="text-subtitle2 text-grey">Crie a base da sua mecânica</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit="onSubmit" class="q-gutter-md">
          <q-input v-model="form.razao_social" label="Nome da Oficina" outlined required />
          <q-input v-model="form.cnpj" label="CNPJ (Opcional)" outlined />
          <q-input v-model="form.name" label="Seu Nome completo" outlined required />
          <q-input v-model="form.email" type="email" label="Email de Acesso" outlined required />
          <q-input v-model="form.password" type="password" label="Senha" outlined required />
          
          <div>
            <q-btn label="Registrar Oficina" type="submit" color="primary" class="full-width" />
          </div>
          <div class="text-center q-mt-md">
            <q-btn flat color="primary" label="Já tenho conta" to="/login" />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useQuasar } from 'quasar'
import { useAuthStore } from 'stores/auth'

const $q = useQuasar()
const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  razao_social: '',
  cnpj: '',
  name: '',
  email: '',
  password: ''
})

const onSubmit = async () => {
  try {
    await authStore.register(form)
    $q.notify({ type: 'positive', message: 'Oficina Registrada com Sucesso!' })
    router.push('/')
  } catch (error) {
    const msg = error.response?.data?.message || 'Erro ao registrar'
    $q.notify({ type: 'negative', message: msg })
  }
}
</script>
