import { useState, useEffect } from 'react'
import Loading from '../../components/shared/Loading'
import { useNavigate } from 'react-router-dom'
import { coursesApi } from '../../api/courses'
import { Table } from '../../components/ui/Table'
import { Button } from '../../components/ui/Button'
import { Alert } from '../../components/ui/Alert'
import SearchFilter from '../../components/ui/SearchFilter'

export function CoursesPage() {
  const navigate = useNavigate()

  const [courses, setCourses] = useState([])
  const [searchText, setSearchText] = useState('')
  const [searchField, setSearchField] = useState('')
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)
  const [success, setSuccess] = useState(null)

  const load = () => {
    setLoading(true)
    coursesApi.getCourses()
      .then(res => setCourses(res.data))
      .catch(() => setError('No se pudieron cargar los cursos.'))
      .finally(() => setLoading(false))
  }

  useEffect(() => {
  const fetchCourses = async () => {
    try {
      setLoading(true)
      const res = await coursesApi.getCourses()
      setCourses(res.data)
    } catch {
      setError('No se pudieron cargar los cursos.')
    } finally {
      setLoading(false)
    }
  }

  fetchCourses()
}, [])


  const handleDelete = async (id) => {
    if (!confirm('¿Seguro que querés eliminar este curso?')) return
    try {
      await coursesApi.deleteCourse(id)
      setSuccess('Curso eliminado correctamente.')
      load()
    } catch {
      setError('No se pudo eliminar el curso.')
    }
  }

  const columns = [
    { key: 'name',    label: 'Nombre' },
    { key: 'teacher', label: 'Profesor', render: row => row.teacher?.name || '—' },
    { key: 'enrollments', label: 'Alumnos', render: row => row.enrollments?.length ?? 0 },
    {
      key: 'actions',
      label: 'Acciones',
      render: row => (
        <div className="row-actions">
          <Button onClick={() => navigate(`/admin/courses/${row.id}/edit`, { state: { resource: row } })} variant="secondary">
            Editar
          </Button>
          <Button onClick={() => navigate(`/admin/courses/${row.id}/enrollments`)} variant="secondary">
            Matrículas
          </Button>
          <Button onClick={() => handleDelete(row.id)} variant="danger">
            Eliminar
          </Button>
        </div>
      ),
    },
  ]

  if (loading) return <Loading />

  return (
    <div className="form-container">
      <div className="page-header">
        <h2 style={{ margin: 0 }}>Cursos</h2>
        <Button onClick={() => navigate('/admin/courses/new')}>+ Nuevo curso</Button>
      </div>

      {error && <Alert type="error" message={error} onClose={() => setError(null)} />}
      {success && <Alert type="success" message={success} onClose={() => setSuccess(null)} />}

      <div style={{ margin: '12px 0 18px' }}>
        <SearchFilter
          value={searchText}
          onChange={setSearchText}
          field={searchField}
          onFieldChange={setSearchField}
          fields={[{ key: 'name', label: 'Nombre' }, { key: 'teacher', label: 'Profesor' }]}
          placeholder="Buscar cursos..."
        />
      </div>

      <Table
        columns={columns}
        data={courses.filter(c => {
          if (!searchText) return true
          const q = searchText.toLowerCase()
          const name = c.name?.toLowerCase() ?? ''
          const teacher = c.teacher?.name?.toLowerCase() ?? ''
          if (!searchField) return name.includes(q) || teacher.includes(q)
          if (searchField === 'name') return name.includes(q)
          if (searchField === 'teacher') return teacher.includes(q)
          return true
        })}
      />
    </div>
  )
}