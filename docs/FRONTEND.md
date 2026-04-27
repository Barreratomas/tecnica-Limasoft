# Frontend

Instrucciones rápidas y estructura del frontend (React + Vite).

Comandos

```bash
cd front
npm install
npm run dev    # desarrollo
npm run build  # producción
```

Estructura principal
- `src/api` — adaptadores Axios por recurso
- `src/components` — UI, layout y componentes reutilizables
- `src/pages` — vistas por rol (admin, teacher, student)
- `src/context/AuthContext.jsx` — autenticación

API base
- `import.meta.env.VITE_API_URL` apunta a la API (por defecto `http://localhost:8000/api`).

Buenas prácticas
- Evitar llamadas GET redundantes: pasar el recurso por `location.state` al navegar a formularios de edición.
- Reusable `SearchFilter` en listados para filtrar en cliente.
- Interceptores Axios para manejar 401 y refresco de token (actualmente redirecciona al login).
