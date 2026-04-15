<template>
  <q-page class="flex flex-center bg-grey-2">
    <q-card class="q-pa-md shadow-2 my_card" style="width: 400px; max-width: 90vw;">
      <q-card-section class="text-center">
        <div class="text-h5 text-weight-bold text-primary">SaaS Oficina</div>
        <div class="text-subtitle2 text-grey">Faça login na sua conta</div>
      </q-card-section>
      <q-card-section>
        <q-form @submit="onSubmit" class="q-gutter-md">
          <q-input v-model="form.email" type="email" label="Email" outlined required />
          <q-input v-model="form.password" type="password" label="Senha" outlined required />
          
          <div>
            <q-btn label="Entrar" type="submit" color="primary" class="full-width" />
          </div>
          <div class="text-center q-mt-md">
            <q-btn flat color="primary" label="Criar uma conta / Oficina" to="/register" />
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
  email: '',
  password: ''
})

const onSubmit = async () => {
  try {
    await authStore.login(form)
    $q.notify({ type: 'positive', message: 'Bem vindo!' })
    router.push('/')
  } catch {
    $q.notify({ type: 'negative', message: 'Credenciais inválidas' })
  }
}
</script>
