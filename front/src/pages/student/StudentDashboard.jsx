import { useNavigate } from 'react-router-dom'
import Loading from '../../components/shared/Loading'
import { useCourses } from '../../hooks/useCourses'
import { useAuth } from '../../hooks/useAuth'
import { Alert } from '../../components/ui/Alert'

export function StudentDashboard() {
  const { user } = useAuth()
  const { courses, loading, error } = useCourses()
  const navigate = useNavigate()

  if (loading) return <Loading />

  return (
    <div className="dashboard">
      <h2>Bienvenido, {user?.name}</h2>
      <p className="muted-paragraph">Estos son tus cursos inscriptos.</p>

      {error && <Alert type="error" message={error} />}

      {!error && courses.length === 0 && (
        <p className="edu-muted">No estás inscripto en ningún curso todavía.</p>
      )}

      <div className="courses-list">
        {courses.map((course) => (
          <div
            key={course.id}
            onClick={() => {
              const enrollment = course.enrollments?.find((e) => e.student_id === user?.id)
              if (enrollment) navigate(`/student/courses/${enrollment.id}`)
            }}
            className="course-card"
          >
            <h3 style={{ margin: '0 0 4px' }}>{course.name}</h3>
            <p className="course-meta">Profesor: {course.teacher?.name || '—'}</p>
            {course.description && <p className="course-desc">{course.description}</p>}
          </div>
        ))}
      </div>
    </div>
  )
}