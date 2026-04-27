import { useState, useEffect } from 'react'
import { useNavigate, useParams, useLocation } from 'react-router-dom'
import { coursesApi } from '../../api/courses'
import { usersApi } from '../../api/users'
import { Input } from '../../components/ui/Input'
import { Button } from '../../components/ui/Button'
import { Alert } from '../../components/ui/Alert'

export function CourseFormPage() {
  const { id }   = useParams()
  const navigate = useNavigate()
  const isEdit   = !!id
  const location = useLocation()

  const preloaded = location.state?.resource
  const preloadedPayload = preloaded ? (preloaded.data ?? preloaded) : null

  const [name, setName]           = useState(preloadedPayload?.name ?? '')
  const [description, setDescription] = useState(preloadedPayload?.description ?? '')
  const [teacherId, setTeacherId] = useState(preloadedPayload?.teacher_id ?? preloadedPayload?.teacher?.id ?? '')
  const [teachers, setTeachers]   = useState([])
  const [errors, setErrors]       = useState({})
  const [error, setError]         = useState(null)
  const [loading, setLoading]     = useState(false)

  useEffect(() => {
    usersApi.getUsers('teacher').then(res => setTeachers(res.data))

    if (isEdit && !preloadedPayload) {
      coursesApi.getCourse(id).then(res => {
        setName(res.data.name)
        setDescription(res.data.description || '')
        setTeacherId(res.data.teacher_id)
      })
    }
  }, [id, isEdit, preloadedPayload])

  const handleSubmit = async (e) => {
    e.preventDefault()
    setErrors({})
    setError(null)
    setLoading(true)

    try {
      const data = { name, description, teacher_id: parseInt(teacherId) }
      if (isEdit) {
        await coursesApi.updateCourse(id, data)
      } else {
        await coursesApi.createCourse(data)
      }
      navigate('/admin/courses')
    } catch (err) {
      if (err.response?.status === 422) {
        setErrors(err.response.data.errors || {})
      } else {
        setError('Error al guardar el curso.')
      }
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="form-container">
      <div style={{ maxWidth: 480 }}>
        <h2>{isEdit ? 'Editar curso' : 'Nuevo curso'}</h2>

        {error && <Alert type="error" message={error} />}

        <form onSubmit={handleSubmit}>
          <Input
            label="Nombre"
            value={name}
            onChange={e => setName(e.target.value)}
            error={errors.name?.[0]}
            required
          />

          <Input
            label="Descripción"
            value={description}
            onChange={e => setDescription(e.target.value)}
            error={errors.description?.[0]}
          />

          <div className="form-row">
            <label className="edu-form-label" htmlFor="teacher-select">Profesor</label>
              <select
                id="teacher-select"
                value={teacherId}
                onChange={e => setTeacherId(e.target.value)}
                required
                className="edu-select"
              >
              <option value="">Seleccioná un profesor</option>
              {teachers.map(t => (
                <option key={t.id} value={t.id}>{t.name}</option>
              ))}
            </select>
            {errors.teacher_id && (
              <span className="edu-error">{errors.teacher_id[0]}</span>
            )}
          </div>

          <div className="form-actions">
            <Button type="submit" loading={loading}>
              {isEdit ? 'Guardar cambios' : 'Crear curso'}
            </Button>
            <Button type="button" variant="secondary" onClick={() => navigate('/admin/courses')}>
              Cancelar
            </Button>
          </div>
        </form>
      </div>
    </div>
  )
}