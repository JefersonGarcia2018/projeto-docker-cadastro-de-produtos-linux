import { boot } from 'quasar/wrappers'
import axios from 'axios'

//Para Desenvolvimento
const api = axios.create({ baseURL: 'http://localhost:8000/api' })



export default boot(({ app, router }) => {
  app.config.globalProperties.$api = api

  api.interceptors.request.use((config) => {
    const token = localStorage.getItem('access_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  })

  api.interceptors.response.use(
    (response) => response,
    (error) => {
      if (error.response && error.response.status === 401) {
        localStorage.removeItem('access_token');
        router.push('/login')
      }
      return Promise.reject(error)
    }
  )
})

export { api }