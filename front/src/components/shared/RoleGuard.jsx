import { Navigate } from 'react-router-dom'
import { useAuth } from '../../hooks/useAuth'
import { ROLE_HOME } from '../../utils/roles'

export function RoleGuard({ role, children }) {
  const { user, isLoading } = useAuth()

  if (isLoading) return null

  if (user?.role !== role) {
    return <Navigate to={ROLE_HOME[user?.role] || '/login'} replace />
  }

  return children
}