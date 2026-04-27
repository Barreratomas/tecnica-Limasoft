import { useParams, useNavigate } from 'react-router-dom'
import Loading from '../../components/shared/Loading'
import { useGrade } from '../../hooks/useGrades'
import { Alert } from '../../components/ui/Alert'
import { Button } from '../../components/ui/Button'

export function StudentCoursePage() {
  const { id }                    = useParams()
  const { grade, loading, error } = useGrade(id)
  const navigate                  = useNavigate()

  if (loading) return <Loading />

  return (
    <div className="form-container">
      <Button variant="secondary" onClick={() => navigate('/student')} className="back-button edu-btn--small">
        ← Volver
      </Button>

      {error && <Alert type="error" message={error} />}

      <div className="detail-card">
        <h3 style={{ marginTop: 0 }}>Tu nota</h3>

        {!grade ? (
          <p className="edu-muted">Sin nota asignada aún.</p>
        ) : (
          <>
            <div style={{ fontSize: 48, fontWeight: 700, color: grade.value >= 6 ? '#166534' : '#991b1b', marginBottom: 8 }}>
              {grade.value}
            </div>

            {grade.notes && (
              <p style={{ color: '#374151', marginBottom: 8 }}>
                <strong>Observaciones:</strong> {grade.notes}
              </p>
            )}

            <p style={{ color: '#94a3b8', fontSize: 13, margin: 0 }}>
              Última actualización: {new Date(grade.updated_at).toLocaleDateString('es-AR')}
            </p>
          </>
        )}
      </div>
    </div>
  )
}