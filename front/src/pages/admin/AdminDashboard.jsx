import { useState, useEffect } from 'react'
import Loading from '../../components/shared/Loading'
import { coursesApi } from '../../api/courses'
import { usersApi } from '../../api/users'
import { Alert } from '../../components/ui/Alert'

export function AdminDashboard() {
  const [stats, setStats]     = useState({ courses: 0, teachers: 0, students: 0 })
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)

  useEffect(() => {
    Promise.all([
      coursesApi.getCourses(),
      usersApi.getUsers('teacher'),
      usersApi.getUsers('student'),
    ])
      .then(([coursesRes, teachersRes, studentsRes]) => {
        setStats({
          courses:  coursesRes.data.length,
          teachers: teachersRes.data.length,
          students: studentsRes.data.length,
        })
      })
      .catch(() => setError('No se pudieron cargar los datos.'))
      .finally(() => setLoading(false))
  }, [])

  const cards = [
    { label: 'Cursos', value: stats.courses, cls: 'stat-card--courses' },
    { label: 'Profesores', value: stats.teachers, cls: 'stat-card--teachers' },
    { label: 'Alumnos', value: stats.students, cls: 'stat-card--students' },
  ]

  if (loading) return <Loading />

  return (
    <div className="dashboard">
      <h2>Panel de administración</h2>

      {error && <Alert type="error" message={error} />}

      <div className="stats-grid">
        {cards.map((card) => (
          <div key={card.label} className={`stat-card ${card.cls}`}>
            <div className="stat-value">{card.value}</div>
            <div className="stat-label">{card.label}</div>
          </div>
        ))}
      </div>
    </div>
  )
}