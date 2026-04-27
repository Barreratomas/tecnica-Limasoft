import { NavLink } from 'react-router-dom'
import { useAuth } from '../../hooks/useAuth'
import './layout.css'

const links = {
  admin: [
    { to: '/admin', label: 'Dashboard' },
    { to: '/admin/courses', label: 'Cursos' },
    { to: '/admin/users', label: 'Usuarios' },
  ],
  teacher: [{ to: '/teacher', label: 'Mis cursos' }],
  student: [{ to: '/student', label: 'Mis cursos' }],
}

export function Sidebar({ open = false, onClose = () => {} }) {
  const { user } = useAuth()
  const roleLinks = links[user?.role] || []

  return (
    <aside className={`app-sidebar ${open ? 'open' : ''}`}>
      <nav className="nav-links">
        {roleLinks.map((link) => (
          <NavLink
            key={link.to}
            to={link.to}
            end
            onMouseEnter={() => {
              const p = prefetchers[link.to]
              if (p) p().catch(() => {})
            }}
            onClick={() => onClose()}
            className={({ isActive }) => `nav-link ${isActive ? 'active' : ''}`.trim()}
          >
            {link.label}
          </NavLink>
        ))}
      </nav>
    </aside>
  )
}


// prefetch para mejorar la experiencia de navegación anticipando la carga de los componentes de las páginas
const prefetchers = {
  '/admin': () => import('../../pages/admin/AdminDashboard'),
  '/admin/courses': () => import('../../pages/admin/CoursesPage'),
  '/admin/users': () => import('../../pages/admin/UsersPage'),
  '/teacher': () => import('../../pages/teacher/TeacherDashboard'),
  '/student': () => import('../../pages/student/StudentDashboard'),
}