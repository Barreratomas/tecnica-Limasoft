import './SearchFilter.css'


export function SearchFilter({ value, onChange, field, onFieldChange, fields = [], placeholder = 'Buscar...' }) {
  return (
    <div className="search-filter">
      {fields.length > 0 && (
        <select className="search-field" value={field} onChange={e => onFieldChange && onFieldChange(e.target.value)}>
          <option value="">Todos</option>
          {fields.map(f => (
            <option key={f.key} value={f.key}>{f.label}</option>
          ))}
        </select>
      )}

      <input
        type="search"
        className="search-input"
        value={value}
        onChange={e => onChange && onChange(e.target.value)}
        placeholder={placeholder}
        aria-label="Buscar"
      />
    </div>
  )
}

export default SearchFilter
