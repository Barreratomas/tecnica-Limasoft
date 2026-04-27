import './input.css'

import { useId } from 'react'

export function Input({ label, error, type = 'text', id, ...props }) {
  const reactId = useId()
  const inputId = id || `input-${reactId}`

  return (
    <div className="edu-field">
      {label && <label className="edu-form-label" htmlFor={inputId}>{label}</label>}
      <input
        id={inputId}
        type={type}
        className="edu-input"
        aria-invalid={!!error}
        {...props}
      />
      {error && <span className="edu-error">{error}</span>} 
    </div>
  )
}