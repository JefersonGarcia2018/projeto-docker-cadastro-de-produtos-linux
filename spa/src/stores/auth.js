import { defineStore } from 'pinia'
import { api } from 'boot/axios'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    tenant: null,
    token: localStorage.getItem('access_token') || null
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async register(form) {
      const { data } = await api.post('/auth/register', form)
      this.setAuth(data)
    },
    async login(form) {
      const { data } = await api.post('/auth/login', form)
      this.setAuth(data)
    },
    async fetchUser() {
      if (this.token) {
        try {
          const { data } = await api.get('/auth/me')
          this.user = data.user
          this.tenant = data.tenant
        } catch {
          this.logout()
        }
      }
    },
    setAuth(data) {
      this.token = data.access_token
      this.user = data.user
      this.tenant = data.tenant
      localStorage.setItem('access_token', data.access_token)
      api.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    },
    async logout() {
      try {
        await api.post('/auth/logout')
      } catch (e) {
        console.error('Logout error:', e)
      }
      this.token = null
      this.user = null
      this.tenant = null
      localStorage.removeItem('access_token')
      delete api.defaults.headers.common['Authorization']
      this.router.push('/login')
    }
  }
})
