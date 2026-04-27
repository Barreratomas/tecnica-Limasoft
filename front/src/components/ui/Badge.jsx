import './badge.css'

const labels = {
  admin: 'Administrador',
  teacher: 'Profesor',
  student: 'Alumno',
}

export function Badge({ role }) {
  const cls = `edu-badge ${role ? `edu-badge--${role}` : ''}`.trim()
  return <span className={cls}>{labels[role] || role}</span>
}