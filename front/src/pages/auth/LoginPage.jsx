import { useState, useId } from 'react'
import { useNavigate } from 'react-router-dom'
import { useAuth } from '../../hooks/useAuth'
import { ROLE_HOME } from '../../utils/roles'
import { Button } from '../../components/ui/Button'
import { Alert } from '../../components/ui/Alert'

export function LoginPage() {
  const { login } = useAuth()
  const navigate  = useNavigate()

  const id = useId()

  const [email, setEmail]       = useState('')
  const [password, setPassword] = useState('')
  const [error, setError]       = useState(null)
  const [loading, setLoading]   = useState(false)

  const handleSubmit = async (e) => {
    e.preventDefault()
    setError(null)
    setLoading(true)

    try {
      const user = await login(email, password)
      navigate(ROLE_HOME[user.role])
    } catch (err) {
      if (err.response?.status === 401) {
        setError('Email o contraseña incorrectos.')
      } else {
        setError('Error al iniciar sesión. Intentá de nuevo.')
      }
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="login-wrapper">
      <div className="login-card edu-card">
        <div className="login-brand">Sistema académico</div>
        <div className="login-subtitle">Accedé a tu cuenta para gestionar cursos y calificaciones</div>

        {error && <Alert type="error" message={error} onClose={() => setError(null)} />}

        <form onSubmit={handleSubmit} aria-labelledby={`login-title-${id}`}>
          <h2 id={`login-title-${id}`}>Iniciar sesión</h2>

          <div className="form-row">
            <label className="edu-form-label" htmlFor={`email-${id}`}>Email</label>
            <input
              id={`email-${id}`}
              type="email"
              value={email}
              onChange={e => setEmail(e.target.value)}
              required
              className="edu-input"
            />
          </div>

          <div className="form-row">
            <label className="edu-form-label" htmlFor={`password-${id}`}>Contraseña</label>
            <input
              id={`password-${id}`}
              type="password"
              value={password}
              onChange={e => setPassword(e.target.value)}
              required
              className="edu-input"
            />
          </div>

          <div className="form-actions">
            <Button type="submit" loading={loading} variant="primary">
              Ingresar
            </Button>
          </div>
        </form>
      </div>
    </div>
  )
}