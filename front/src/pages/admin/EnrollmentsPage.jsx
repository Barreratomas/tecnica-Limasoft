import { useState, useEffect } from 'react'
import Loading from '../../components/shared/Loading'
import { useParams, useNavigate } from 'react-router-dom'
import { coursesApi } from '../../api/courses'
import { usersApi } from '../../api/users'
import { Table } from '../../components/ui/Table'
import { Button } from '../../components/ui/Button'
import { Alert } from '../../components/ui/Alert'
import SearchFilter from '../../components/ui/SearchFilter'

export function EnrollmentsPage() {
  const { id }   = useParams()
  const navigate = useNavigate()

  const [students, setStudents]   = useState([])
  const [allStudents, setAllStudents] = useState([])
  const [searchText, setSearchText] = useState('')
  const [searchField, setSearchField] = useState('')
  const [selectedId, setSelectedId]  = useState('')
  const [loading, setLoading]     = useState(true)
  const [saving, setSaving]       = useState(false)
  const [error, setError]         = useState(null)
  const [success, setSuccess]     = useState(null)

  const load = () => {
    Promise.all([
      coursesApi.getCourseStudents(id),
      usersApi.getUsers('student'),
    ])
      .then(([enrolledRes, allRes]) => {
        setStudents(enrolledRes.data)
        const enrolledIds = enrolledRes.data.map(e => e.student_id)
        setAllStudents(allRes.data.filter(s => !enrolledIds.includes(s.id)))
      })
      .catch(() => setError('No se pudieron cargar los datos.'))
      .finally(() => setLoading(false))
  }

  useEffect(() => { load() }, [id])

  const handleEnroll = async () => {
    if (!selectedId) return
    setSaving(true)
    try {
      await coursesApi.enrollStudent(id, parseInt(selectedId))
      setSuccess('Alumno matriculado correctamente.')
      setSelectedId('')
      load()
    } catch (err) {
      if (err.response?.status === 422) {
        setError('El alumno ya está matriculado.')
      } else {
        setError('No se pudo matricular al alumno.')
      }
    } finally {
      setSaving(false)
    }
  }

  const handleUnenroll = async (enrollmentId) => {
    if (!confirm('¿Seguro que querés desmatricular a este alumno?')) return
    try {
      await coursesApi.unenrollStudent(enrollmentId)
      setSuccess('Alumno desmatriculado correctamente.')
      load()
    } catch {
      setError('No se pudo desmatricular al alumno.')
    }
  }

  const columns = [
    { key: 'student', label: 'Alumno', render: row => row.student?.name },
    { key: 'email',   label: 'Email',  render: row => row.student?.email },
    { key: 'grade',   label: 'Nota',   render: row => row.grade?.value ?? 'Sin nota' },
    {
      key: 'actions',
      label: 'Acciones',
      render: row => (
        <Button variant="danger" onClick={() => handleUnenroll(row.id)}>
          Desmatricular
        </Button>
      ),
    },
  ]

  if (loading) return <Loading />

  return (
    <div className="form-container">
      <Button variant="secondary" onClick={() => navigate('/admin/courses')} className="back-button edu-btn--small">
        ← Volver
      </Button>

      <h2 style={{ marginBottom: 24 }}>Matrículas del curso</h2>

      {error && <Alert type="error" message={error} onClose={() => setError(null)} />}
      {success && <Alert type="success" message={success} onClose={() => setSuccess(null)} />}

      <div style={{ display: 'flex', gap: 8, marginBottom: 24 }}>
        <label className="edu-form-label" htmlFor="enroll-select" style={{ display: 'none' }}>Seleccioná un alumno</label>
        <select
          id="enroll-select"
          value={selectedId}
          onChange={e => setSelectedId(e.target.value)}
          className="edu-select"
          style={{ flex: 1 }}
        >
          <option value="">Seleccioná un alumno para matricular</option>
          {allStudents.map(s => (
            <option key={s.id} value={s.id}>{s.name} — {s.email}</option>
          ))}
        </select>
        <Button onClick={handleEnroll} loading={saving} disabled={!selectedId}>
          Matricular
        </Button>
      </div>

      <div style={{ margin: '8px 0 18px' }}>
        <SearchFilter
          value={searchText}
          onChange={setSearchText}
          field={searchField}
          onFieldChange={setSearchField}
          fields={[{ key: 'name', label: 'Nombre' }, { key: 'email', label: 'Email' }]}
          placeholder="Buscar inscriptos..."
        />
      </div>

      <Table
        columns={columns}
        data={students.filter(s => {
          if (!searchText) return true
          const q = searchText.toLowerCase()
          const name = s.student?.name?.toLowerCase() ?? ''
          const email = s.student?.email?.toLowerCase() ?? ''
          if (!searchField) return name.includes(q) || email.includes(q)
          if (searchField === 'name') return name.includes(q)
          if (searchField === 'email') return email.includes(q)
          return true
        })}
      />
    </div>
  )
}