import { Navigate } from 'react-router-dom'
import { useAuth } from '../../hooks/useAuth'

export function PrivateRoute({ children }) {
  const { isAuthenticated, isLoading } = useAuth()

  if (isLoading) return null

  return isAuthenticated ? children : <Navigate to="/login" replace />
}