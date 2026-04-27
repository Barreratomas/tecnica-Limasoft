import { useState, useEffect } from 'react'
import Loading from '../../components/shared/Loading'
import { useNavigate } from 'react-router-dom'
import { usersApi } from '../../api/users'
import { Table } from '../../components/ui/Table'
import { Button } from '../../components/ui/Button'
import { Badge } from '../../components/ui/Badge'
import { Alert } from '../../components/ui/Alert'
import SearchFilter from '../../components/ui/SearchFilter'

export function UsersPage() {
  const navigate = useNavigate()

  const [users, setUsers]     = useState([])
  const [filter, setFilter]   = useState('')
  const [searchText, setSearchText] = useState('')
  const [searchField, setSearchField] = useState('')
  const [loading, setLoading] = useState(true)
  const [error, setError]     = useState(null)

  useEffect(() => {
    usersApi.getUsers(filter || null)
      .then(res => setUsers(res.data))
      .catch(() => setError('No se pudieron cargar los usuarios.'))
      .finally(() => setLoading(false))
  }, [filter])

  const columns = [
    { key: 'name',  label: 'Nombre' },
    { key: 'email', label: 'Email' },
    {
      key: 'role',
      label: 'Rol',
      render: row => {
        const role = row.roles?.[0]?.name
        return <Badge role={role} />
      },
    },
    {
      key: 'actions',
      label: 'Acciones',
      render: row => (
        <Button variant="secondary" onClick={() => navigate(`/admin/users/${row.id}/edit`, { state: { resource: row } })}>
          Editar
        </Button>
      ),
    },
  ]

  if (loading) return <Loading />

  return (
    <div className="form-container">
      <div className="page-header">
        <h2 style={{ margin: 0 }}>Usuarios</h2>
        <Button onClick={() => navigate('/admin/users/new')}>+ Nuevo usuario</Button>
      </div>

      {error && <Alert type="error" message={error} onClose={() => setError(null)} />}

      <div style={{ marginBottom: 16, display: 'flex', gap: 12, alignItems: 'flex-end' }}>
        <div style={{ flex: 1 }}>
          <label className="edu-form-label" htmlFor="filter-select">Filtrar por rol</label>
          <select
            id="filter-select"
            value={filter}
            onChange={e => setFilter(e.target.value)}
            className="edu-select"
          >
            <option value="">Todos los roles</option>
            <option value="admin">Administradores</option>
            <option value="teacher">Profesores</option>
            <option value="student">Alumnos</option>
          </select>
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', minWidth: 320 }}>
          <label className="edu-form-label">Buscar</label>
          <SearchFilter
            value={searchText}
            onChange={setSearchText}
            field={searchField}
            onFieldChange={setSearchField}
            fields={[{ key: 'name', label: 'Nombre' }, { key: 'email', label: 'Email' }, { key: 'role', label: 'Rol' }]}
            placeholder="Buscar usuarios..."
          />
        </div>
      </div>

      <Table
        columns={columns}
        data={users.filter(u => {
          
          
          if (filter && !(u.roles || []).some(r => r.name === filter)) return false

          if (!searchText) return true
          const q = searchText.toLowerCase()
          const name = u.name?.toLowerCase() ?? ''
          const email = u.email?.toLowerCase() ?? ''
          const role = (u.roles?.[0]?.name ?? '').toLowerCase()

          if (!searchField) return name.includes(q) || email.includes(q) || role.includes(q)
          if (searchField === 'name') return name.includes(q)
          if (searchField === 'email') return email.includes(q)
          if (searchField === 'role') return role.includes(q)
          return true
        })}
      />
    </div>
  )
}