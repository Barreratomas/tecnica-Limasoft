# Setup

Este documento explica cómo levantar el proyecto en desarrollo, con y sin Docker.

Requisitos
- Git
- Docker / Docker Compose (opcional)
- PHP 8.2, Composer (si no usa Docker)
- Node.js 18+ (si no usa Docker)

Con Docker (recomendado)

```bash
git clone https://github.com/Barreratomas/tecnica-Limasoft.git
cd tecnica-Limasoft

# copiar ejemplos de env
cp back/.env.example back/.env
cp front/.env.example front/.env

docker compose up -d

# instalar dependencias dentro del contenedor y migrar
docker compose exec app composer install
docker compose exec app npm install --prefix front
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Sin Docker (local)

Backend
```bash
cd back
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

Frontend
```bash
cd front
npm install
cp .env.example .env
npm run dev
```

URLs útiles

- API: http://localhost:8000/api
- Swagger UI: http://localhost:8000/api/documentation
- Frontend: http://localhost:5173

Usuarios de prueba (credenciales)

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@demo.com | password |
| Profesor      | garcia@demo.com | password |
| Profesor      | lopez@demo.com  | password |
| Alumno        | perez@demo.com  | password |
