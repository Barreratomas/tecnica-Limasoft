##  Testing

### Casos

* Restricción de acceso por rol
* Validación de ownership
* Integridad de datos

### Comandos

```
php artisan test --filter=GradeTest
php artisan test --filter=EnrollmentTest
php artisan test --filter=AuthTest
```

Ejecutar todos los tests (backend):

```bash
cd back
php artisan test
```

Si usas Docker:

```bash
docker compose exec app php artisan test
```

