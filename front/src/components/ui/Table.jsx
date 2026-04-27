import './table.css'

export function Table({ columns, data }) {
  if (!data?.length) {
    return <p className="edu-muted">No hay datos para mostrar.</p>
  }

  return (
    <div className="edu-table-wrapper">
      <table className="edu-table" role="table" aria-label="Data table">
        <thead>
          <tr>
            {columns.map((col) => (
              <th key={col.key} scope="col">{col.label}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {data.map((row, i) => (
            <tr key={i}>
              {columns.map((col) => (
                <td key={col.key}>{col.render ? col.render(row) : row[col.key]}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}