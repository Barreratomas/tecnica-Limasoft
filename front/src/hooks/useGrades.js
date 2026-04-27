import { useState, useEffect } from 'react'
import { gradesApi } from '../api/grades'

export function useGrade(enrollmentId) {
  const [grade, setGrade]   = useState(null)
  const [loading, setLoading] = useState(true)
  const [error, setError]   = useState(null)

  useEffect(() => {
    if (!enrollmentId) return

    gradesApi.getGrade(enrollmentId)
      .then(res => setGrade(res.data))
      .catch(err => {
        if (err.response?.status === 404) {
          setGrade(null)
        } else {
          setError('No se pudo cargar la nota.')
        }
      })
      .finally(() => setLoading(false))
  }, [enrollmentId])

  return { grade, loading, error }
}