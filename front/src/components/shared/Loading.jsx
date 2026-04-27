import './loading.css'

export default function Loading() {
  return (
    <div className="loading-root" aria-live="polite" aria-busy="true">
      <div className="loading-spinner" />
    </div>
  )
}
