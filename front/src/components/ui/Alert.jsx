import { useEffect } from 'react'
import './alert.css'

export function Alert({ type = 'error', message, onClose }) {
  useEffect(() => {
    if (!onClose) return
    const timer = setTimeout(onClose, 4000)
    return () => clearTimeout(timer)
  }, [onClose])

  if (!message) return null

  const cls = `edu-alert edu-alert--${type}`

  return (
    <div className={cls} role="alert">
      <span>{message}</span>
      {onClose && (
        <button className="close" onClick={onClose} aria-label="Cerrar">×</button>
      )}
    </div>
  )
}