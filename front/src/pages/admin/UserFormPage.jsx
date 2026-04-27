import { useState, useEffect } from "react";
import { useNavigate, useParams, useLocation } from "react-router-dom";
import { usersApi } from "../../api/users";
import { Input } from "../../components/ui/Input";
import { Button } from "../../components/ui/Button";
import { Alert } from "../../components/ui/Alert";

export function UserFormPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const location = useLocation();
  const isEdit = !!id;
  const preloaded = location.state?.resource;
  const preloadedPayload = isEdit
    ? preloaded
      ? (preloaded.data ?? preloaded)
      : null
    : null;

  const [name, setName] = useState(
    isEdit ? (preloadedPayload?.name ?? "") : "",
  );
  const [email, setEmail] = useState(
    isEdit ? (preloadedPayload?.email ?? "") : "",
  );
  const [password, setPassword] = useState("");
  const [role, setRole] = useState(
    preloadedPayload?.roles?.[0]?.name ?? "student",
  );
  const [errors, setErrors] = useState({});
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (isEdit && !preloadedPayload) {
      usersApi.getUser(id).then((res) => {
        const payload = res.data?.data ?? res.data;
        setName(payload?.name || "");
        setEmail(payload?.email || "");
        setRole(payload?.roles?.[0]?.name || "student");
      });
    }
  }, [id, isEdit, preloadedPayload]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    setError(null);
    setLoading(true);

    try {
      const data = { name, email, role };
      if (!isEdit || password) data.password = password;

      if (isEdit) {
        await usersApi.updateUser(id, data);
      } else {
        await usersApi.createUser(data);
      }
      navigate("/admin/users");
    } catch (err) {
      if (err.response?.status === 422) {
        setErrors(err.response.data.errors || {});
      } else {
        setError("Error al guardar el usuario.");
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="form-container">
      <div style={{ maxWidth: 480 }}>
        <h2>{isEdit ? "Editar usuario" : "Nuevo usuario"}</h2>

        {error && <Alert type="error" message={error} />}

        <form onSubmit={handleSubmit} autoComplete="off">
          <Input
            label="Nombre"
            value={name}
            onChange={(e) => setName(e.target.value)}
            error={errors.name?.[0]}
            required
          />

          <Input
            label="Email"
            type="email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            error={errors.email?.[0]}
            required
            autoComplete="off"
          />

          <Input
            label={isEdit ? "Nueva contraseña (opcional)" : "Contraseña"}
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            error={errors.password?.[0]}
            required={!isEdit}
            autoComplete="new-password"
          />

          <div className="form-row">
            <label className="edu-form-label" htmlFor="role-select">
              Rol
            </label>
            <select
              id="role-select"
              value={role}
              onChange={(e) => setRole(e.target.value)}
              className="edu-select"
            >
              <option value="admin">Administrador</option>
              <option value="teacher">Profesor</option>
              <option value="student">Alumno</option>
            </select>
          </div>

          <div className="form-actions">
            <Button type="submit" loading={loading}>
              {isEdit ? "Guardar cambios" : "Crear usuario"}
            </Button>
            <Button
              type="button"
              variant="secondary"
              onClick={() => navigate("/admin/users")}
            >
              Cancelar
            </Button>
          </div>
        </form>
      </div>
    </div>
  );
}
