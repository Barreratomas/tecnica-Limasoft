import { useState, useEffect } from 'react'
import Loading from '../../components/shared/Loading'
import { useParams, useNavigate } from 'react-router-dom'
import { coursesApi } from '../../api/courses'
import { gradesApi } from '../../api/grades'
import { Button } from '../../components/ui/Button'
import { Alert } from '../../components/ui/Alert'
import SearchFilter from '../../components/ui/SearchFilter'

export function TeacherCoursePage() {
  const { id }       = useParams()
  const navigate     = useNavigate()

  const [course, setCourse]     = useState(null)
  const [students, setStudents] = useState([])
  const [searchText, setSearchText] = useState('')
  const [searchField, setSearchField] = useState('')
  const [loading, setLoading]   = useState(true)
  const [error, setError]       = useState(null)


  const [values, setValues]     = useState({})
  const [notes, setNotes]       = useState({})
  const [saving, setSaving]     = useState({})
  const [feedback, setFeedback] = useState({})

  useEffect(() => {
    Promise.all([
      coursesApi.getCourse(id),
      coursesApi.getCourseStudents(id),
    ])
      .then(([courseRes, studentsRes]) => {
        setCourse(courseRes.data)
        setStudents(studentsRes.data)

        // inicializar valores con las notas existentes
        const initialValues = {}
        const initialNotes  = {}
        studentsRes.data.forEach(enrollment => {
          initialValues[enrollment.id] = enrollment.grade?.value ?? ''
          initialNotes[enrollment.id]  = enrollment.grade?.notes ?? ''
        })
        setValues(initialValues)
        setNotes(initialNotes)
      })
        .catch(() => setError('No se pudo cargar el curso.'))
      .finally(() => setLoading(false))
  }, [id])

  const validateGrade = (value) => {
    const num = parseFloat(value)
    if (isNaN(num)) return 'La nota debe ser un número.'
    if (num < 0 || num > 10) return 'La nota debe estar entre 0 y 10.'
    if (!/^\d+(\.\d{1,2})?$/.test(String(value))) return 'Máximo 2 decimales.'
    return null
  }

  const handleSave = async (enrollmentId) => {
    const validationError = validateGrade(values[enrollmentId])
    if (validationError) {
      setFeedback(prev => ({ ...prev, [enrollmentId]: { type: 'error', message: validationError } }))
      return
    }

    setSaving(prev => ({ ...prev, [enrollmentId]: true }))
    setFeedback(prev => ({ ...prev, [enrollmentId]: null }))

    try {
      await gradesApi.updateGrade(enrollmentId, {
        value: parseFloat(values[enrollmentId]),
        notes: notes[enrollmentId] || null,
      })
      setFeedback(prev => ({ ...prev, [enrollmentId]: { type: 'success', message: 'Nota guardada.' } }))
    } catch {
      setFeedback(prev => ({ ...prev, [enrollmentId]: { type: 'error', message: 'Error al guardar.' } }))
    } finally {
      setSaving(prev => ({ ...prev, [enrollmentId]: false }))
    }
  }

  if (loading) return <Loading />
  if (error) return <Alert type="error" message={error} />

  return (
    <div className="form-container">
      <Button variant="secondary" onClick={() => navigate('/teacher')} className="back-button edu-btn--small">
        ← Volver
      </Button>

      <h2 style={{ marginBottom: 4 }}>{course?.name}</h2>
      <p className="muted-paragraph">{students.length} alumno/s inscriptos</p>

      <div style={{ margin: '8px 0 18px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <SearchFilter
          value={searchText}
          onChange={setSearchText}
          field={searchField}
          onFieldChange={setSearchField}
          fields={[{ key: 'name', label: 'Nombre' }, { key: 'email', label: 'Email' }]}
          placeholder="Buscar alumno..."
        />
      </div>

      {students.length === 0 && <p className="edu-muted">No hay alumnos inscriptos en este curso.</p>}

      <div className="courses-list">
        {students
          .filter(enrollment => {
            if (!searchText) return true
            const q = searchText.toLowerCase()
            const name = enrollment.student?.name?.toLowerCase() ?? ''
            const email = enrollment.student?.email?.toLowerCase() ?? ''
            if (!searchField) return name.includes(q) || email.includes(q)
            if (searchField === 'name') return name.includes(q)
            if (searchField === 'email') return email.includes(q)
            return true
          })
          .map((enrollment) => (
          <div key={enrollment.id} className="course-card">
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', flexWrap: 'wrap', gap: 12 }}>
              <div>
                <p style={{ margin: '0 0 2px', fontWeight: 600 }}>{enrollment.student?.name}</p>
                <p style={{ margin: 0, fontSize: 13, color: 'var(--edu-muted)' }}>{enrollment.student?.email}</p>
              </div>

              <div style={{ display: 'flex', alignItems: 'center', gap: 8, flexWrap: 'wrap' }}>
                <div>
                  <label className="edu-form-label" style={{ fontSize: 12, marginBottom: 2 }}>Nota (0-10)</label>
                  <input
                    type="number"
                    min="0"
                    max="10"
                    step="0.01"
                    value={values[enrollment.id] ?? ''}
                    onChange={e => setValues(prev => ({ ...prev, [enrollment.id]: e.target.value }))}
                    className="small-input"
                  />
                </div>

                <div>
                  <label className="edu-form-label" style={{ fontSize: 12, marginBottom: 2 }}>Observaciones</label>
                  <input
                    type="text"
                    value={notes[enrollment.id] ?? ''}
                    onChange={e => setNotes(prev => ({ ...prev, [enrollment.id]: e.target.value }))}
                    placeholder="Opcional"
                    className="small-text"
                  />
                </div>

                <div style={{ alignSelf: 'flex-end' }}>
                  <Button onClick={() => handleSave(enrollment.id)} loading={saving[enrollment.id]}>
                    Guardar
                  </Button>
                </div>
              </div>
            </div>

            {feedback[enrollment.id] && (
              <div style={{ marginTop: 8 }}>
                <Alert type={feedback[enrollment.id].type} message={feedback[enrollment.id].message} onClose={() => setFeedback(prev => ({ ...prev, [enrollment.id]: null }))} />
              </div>
            )}
          </div>
        ))}
      </div>
    </div>
  )
}