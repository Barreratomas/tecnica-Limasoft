import './button.css'

export function Button({ children, variant = 'primary', loading = false, className = '', type, ...props }) {
  const classes = ['edu-btn', `edu-btn--${variant}`]
  if (loading) classes.push('is-loading')
  if (className) classes.push(className)
  const buttonType = type || 'button'

  return (
    <button type={buttonType} className={classes.join(' ')} disabled={loading || props.disabled} {...props}>
      {loading ? (
        <span className="btn-spinner" aria-hidden="true">
          <span className="btn-spinner-dot" />
        </span>
      ) : (
        children
      )}
    </button>
  )
}