import instance from './axios'

export const usersApi = {
  getUsers: (role = null) =>
    instance.get('/users', { params: role ? { role } : {} }),

  getUser: (id) =>
    instance.get(`/users/${id}`),

  createUser: (data) =>
    instance.post('/users', data),

  updateUser: (id, data) =>
    instance.put(`/users/${id}`, data),
}