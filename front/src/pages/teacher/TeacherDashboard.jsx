import { useNavigate } from 'react-router-dom'
import Loading from '../../components/shared/Loading'
import { useCourses } from '../../hooks/useCourses'
import { useAuth } from '../../hooks/useAuth'
import { Alert } from '../../components/ui/Alert'

export function TeacherDashboard() {
  const { user } = useAuth()
  const { courses, loading, error } = useCourses()
  const navigate = useNavigate()

  if (loading) return <Loading />

  return (
    <div className="dashboard">
      <h2>Bienvenido, {user?.name}</h2>
      <p className="muted-paragraph">Estos son tus cursos asignados.</p>

      {error && <Alert type="error" message={error} />}

      {!error && courses.length === 0 && (
        <p className="edu-muted">No tenés cursos asignados todavía.</p>
      )}

      <div className="courses-list">
        {courses.map((course) => (
          <div
            key={course.id}
            onClick={() => navigate(`/teacher/courses/${course.id}`)}
            className="course-card"
          >
            <h3 style={{ margin: '0 0 4px' }}>{course.name}</h3>
            <p className="course-meta">{course.enrollments?.length ?? 0} alumno/s inscriptos</p>
            {course.description && (
              <p className="course-desc">{course.description}</p>
            )}
          </div>
        ))}
      </div>
    </div>
  )
}