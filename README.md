# Sistema académico

Sistema de gestión de notas académicas con roles diferenciados: administrador, profesor y alumno.

## Stack

- **Backend:** Laravel, Sanctum, Spatie Permission
- **Frontend:** React, Vite, React Router, Axios
- **Base de datos:** MySQL 
- **Infraestructura:** Docker Compose

## Instalación

### Con Docker

```bash
git clone https://github.com/Barreratomas/tecnica-Limasoft.git
cd tecnica-Limasoft

cp back/.env.example back/.env
cp front/.env.example front/.env

docker compose up -d

docker compose exec app php artisan migrate --seed
```

La API queda en `http://localhost:8000/api`.
El frontend en `http://localhost:5173`.

### Sin Docker

**Backend:**
```bash
cd back
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

**Frontend:**
```bash
cd front
npm install
cp .env.example .env
npm run dev
```

## Usuarios de prueba

| Rol           | Email               | Contraseña |
|---------------|---------------------|------------|
| Administrador | admin@demo.com      | password   |
| Profesor      | garcia@demo.com     | password   |
| Profesor      | lopez@demo.com      | password   |
| Alumno        | perez@demo.com      | password   |
| Alumno        | martinez@demo.com   | password   |
| Alumno        | rodriguez@demo.com  | password   |
| Alumno        | gomez@demo.com      | password   |

## Tests

```bash
cd back
php artisan test
```

## Documentación técnica

Ver la carpeta `docs/` para la documentación técnica organizada (setup, backend, frontend, API, testing y troubleshooting).

Documentación relevante:

- `docs/SETUP.md` — instalación y puesta en marcha (Docker y local).
- `docs/BACKEND.md` — migraciones, seeders, generación de Swagger y comandos útiles.
- `docs/FRONTEND.md` — desarrollo, build y estructura del frontend.
- `docs/API.md` — endpoints principales y referencia a `/api/documentation`.
- `docs/TESTING.md` — cómo ejecutar tests.
- `docs/TROUBLESHOOTING.md` — errores comunes y soluciones rápidas.

