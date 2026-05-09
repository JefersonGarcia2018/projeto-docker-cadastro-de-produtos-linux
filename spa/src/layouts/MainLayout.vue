<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="toggleLeftDrawer" />

        <q-toolbar-title> {{ authStore.tenant ? authStore.tenant.razao_social : 'SaaS Oficina' }} </q-toolbar-title>

        <div>v1.0.0</div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header> Menu </q-item-label>

        <EssentialLink v-for="link in linksList" :key="link.title" v-bind="link" />
        
        <q-item clickable @click="onLogout">
          <q-item-section avatar>
            <q-icon name="logout" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Sair</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import EssentialLink from 'components/EssentialLink.vue'
import { useAuthStore } from 'stores/auth'

const authStore = useAuthStore()

const linksList = [
  {
    title: 'Dashboard',
    icon: 'home',
    link: '/',
  },
  {
    title: 'Clientes',
    icon: 'people',
    link: '/clientes',
  },
  {
    title: 'Veículos',
    icon: 'directions_car',
    link: '/veiculos',
  },
  {
    title: 'Serviços (M.O)',
    icon: 'build',
    link: '/servicos',
  },
  {
    title: 'Peças / Produtos',
    icon: 'inventory_2',
    link: '/produtos',
  },
]

const leftDrawerOpen = ref(false)

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value
}

function onLogout() {
  authStore.logout()
}
</script>
