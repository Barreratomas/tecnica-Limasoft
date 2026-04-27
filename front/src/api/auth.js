import instance from './axios'

export const authApi = {
  login: (email, password) =>
    instance.post('/auth/login', { email, password }),

  logout: () =>
    instance.post('/auth/logout'),

  me: () =>
    instance.get('/auth/me'),
}