import { useAuth } from '../../hooks/useAuth'
import { Badge } from '../ui/Badge'
import { Button } from '../ui/Button'
import './layout.css'

export function Navbar({ onToggleSidebar }) {
  const { user, logout } = useAuth()

  return (
    <nav className="app-navbar">
      <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
        <button className="mobile-menu-btn" onClick={onToggleSidebar} aria-label="Abrir menú">
          ☰
        </button>
        <span className="app-brand">Sistema académico</span>
      </div>

      <div style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
        <span style={{ fontSize: 14 }}>{user?.name}</span>
        <Badge role={user?.role} />
        <Button variant="secondary" onClick={logout} className="edu-btn--small">
          Salir
        </Button>
      </div>
    </nav>
  )
}