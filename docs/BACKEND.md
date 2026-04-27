# Backend

Contenido breve sobre la parte servidor: migraciones, seeders, Swagger y comandos habituales.

Estructura relevante
- `app/` — controllers, services, repositories, policies
- `routes/api.php` — rutas API
- `database/migrations` — migraciones
- `database/seeders` — seeders

Comandos útiles

```bash
cd back
# ejecutar migraciones
php artisan migrate

# resetear (borrar datos) y seedear — usar sólo en desarrollo
php artisan migrate:fresh --seed

# ejecutar tests
php artisan test

# generar documentación OpenAPI (l5-swagger)
php artisan l5-swagger:generate
```

Seeder idempotente
- Evitar `Model::create()` sin comprobar existencia cuando se re-ejecuta el seeder.
- Usar `Model::firstOrCreate([...])` o `Model::updateOrCreate([...], [...])` para evitar errores como "A role `admin` already exists".

Problemas comunes
- Duplicar migraciones (por ejemplo `personal_access_tokens`) puede lanzar excepciones y devolver 500 en la API.
- Si ves "table xxxx already exists" considera limpiar tablas o usar `migrate:fresh` en desarrollo.

Swagger / OpenAPI
- UI: `/api/documentation`
- Archivo generado: `back/storage/api-docs/api-docs.json`
- Si `l5-swagger:generate` emite warnings sobre `@OA\Info()` o paths faltantes, añade una clase `App\Docs\OpenApi` con la anotación `@OA\Info()` o ajusta `config/l5-swagger.php` para escanear las rutas correctas.
