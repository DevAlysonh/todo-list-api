import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import TasksView from '../views/TasksView.vue'

const routes = [
  { path: '/', redirect: '/tasks' },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/tasks', name: 'Tasks', component: TasksView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router