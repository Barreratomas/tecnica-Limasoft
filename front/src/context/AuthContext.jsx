import {  useState, useEffect, useCallback, useMemo } from 'react'

import { AuthContext } from './AuthContextObject'
import { authApi } from '../api/auth'

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null)
  const [token, setToken] = useState(localStorage.getItem('token'))
  const [isLoading, setIsLoading] = useState(!!token)

  useEffect(() => {
    if (!token) return

    authApi.me()
    .then(res => setUser(res.data))
    .catch(() => {
      localStorage.clear()
      setToken(null)
      setUser(null)
    })
    .finally(() => setIsLoading(false))
  }, [token])

  const login = useCallback(async (email, password) => {
    const res = await authApi.login(email, password)
    localStorage.setItem('token', res.data.token)
    setToken(res.data.token)
    setUser(res.data.user)
    return res.data.user
  }, [])


  const logout = useCallback(async () => {
    try {
      await authApi.logout()
    } finally {
      localStorage.clear()
      setToken(null)
      setUser(null)
    }
  }, [])

  const value = useMemo(() => ({
    user,
    token,
    isAuthenticated: !!token && !!user,
    isLoading,
    login,
    logout,
  }), [user, token, isLoading, login, logout])

  return (
    <AuthContext.Provider value={value}>
      {children}
    </AuthContext.Provider>
  )
}