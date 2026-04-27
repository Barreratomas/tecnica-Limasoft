import { useState, useEffect } from 'react'
import { coursesApi } from '../api/courses'

export function useCourses() {
  const [courses, setCourses] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)

  useEffect(() => {
    coursesApi.getCourses()
      .then(res => setCourses(res.data))
      .catch(() => setError('No se pudieron cargar los cursos.'))
      .finally(() => setLoading(false))
  }, [])

  return { courses, loading, error }
}