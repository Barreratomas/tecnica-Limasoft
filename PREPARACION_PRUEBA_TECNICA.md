# Preparación para la prueba técnica — Limasoft

Esta guía breve te indica qué estudiar, profundizar y practicar antes de la demo técnica.

**Resumen rápido**
- Tiempo recomendado: 3–7 días según disponibilidad.
- Prioridad: API Laravel (autenticación, roles, validaciones, tests) + React (autenticación, UI de roles, tablas de notas).

**1. Objetivos de la prueba**
- Implementar API REST (Laravel) para gestionar cursos, matrículas y notas.
- Roles: Alumno (ver sus notas), Profesor (ver/editar notas de sus alumnos), Administrador (CRUD cursos y asignación de profesores).
- Se valora: buenas prácticas (POO, SOLID), autenticación/roles, pruebas básicas y preparación para demo en vivo.

**2. Conceptos backend (Laravel) — Prioritarios**
- Estructura de proyecto: `app/Http/Controllers`, `Services`, `Repositories`, `Models`, `Policies`.
- Eloquent: relaciones (hasMany, belongsToMany), pivotes (enrollment), eager loading, mutators/accessors.
- Migrations y seeders: definir tablas `users`, `courses`, `enrollments`, `grades`.
- Validaciones: Form Requests (`app/Http/Requests`) y reglas personalizadas.
- Autenticación: Sanctum (SPA/cookie) o Passport/JWT — flujo de login, refresh y logout.
- Autorización: Policies / Gates; o `spatie/laravel-permission` para roles/permissions.
- Controllers: Resource controllers, API Resources (transformers) para respuestas consistentes.
- Servicios y repositorios: separar lógica de negocio y persistencia (mejor testabilidad).
- Manejo de errores: Responses JSON estandarizados, códigos HTTP, excepciones personalizadas.
- Testing: Feature tests para endpoints (creación/actualización de notas), Unit tests para servicios.
- Documentación API: OpenAPI / l5-swagger o Postman collection.

**3. Conceptos frontend (React) — Prioritarios**
- Estructura de la app: rutas `/login`, `/courses`, `/course/:id/grades`.
- Autenticación: flujo de login, almacenamiento seguro (cookies httpOnly con Sanctum o token en memoria), protección de rutas.
- Control de roles en UI: esconder/mostrar acciones según rol (Alumno/Profesor/Admin).
- Manejo de estado: `useState`/`useReducer` o `Context`/`Redux` si lo usas.
- Formularios y validaciones: client-side + mostrar errores de la API.
- Tablas y edición inline o modal para notas (usabilidad para profesor).
- Fetching: `fetch` o `axios`, manejo de loaders y errores.
- Testing: React Testing Library para componentes clave (login, tabla de notas).

**4. Arquitectura y buenas prácticas a dominar**
- POO y SOLID: desacoplar, inyección de dependencias (Service Container), clases pequeñas con responsabilidad única.
- Diseño de entidades: evitar lógica en controllers, usar Services/DTOs.
- Patrones útiles: Repository, Service, Factory (para tests), Policy/Strategy según autorización.
- Versionado y ramas: uso de `feature/*`, commits atómicos, `README` con cómo ejecutar.

**5. Seguridad y producción**
- Validar y sanitizar inputs.
- Control de acceso (Policies/roles) correctamente probado.
- Protección CSRF (cuando uses cookies), CORS correctamente configurado.
- No exponer datos sensibles en la API.

**6. Pruebas y QA**
- Laravel: `php artisan test` — crear tests para: login, endpoint de actualización de nota (solo profesor asignado), endpoints de administrador (crear curso).
- Factories y seeders para crear datos de prueba rápidos.
- React: tests de renderizado, simulación de eventos en la UI (editar nota).

**7. Ejercicios prácticos para practicar (ordénalos por prioridad)**
1. Implementar login con Sanctum y crear 3 usuarios con roles en seeders.
2. Crear endpoints básicos: listar cursos, ver notas por curso, actualizar nota (solo profesor con relación).
3. Escribir un Feature test que verifique que un profesor no asignado no puede editar la nota.
4. Construir una vista React con tabla de notas y edición inline (o modal) para profesor.
5. Añadir control de roles en el frontend (ocultar botones si no corresponde).
6. Documento rápido: exportar notas a CSV o endpoint simple para descarga.
7. Pequeña mejora en caliente: agregar un campo `comment` a `grades` (migración, API, validación, frontend) — práctica típica para la demo.

**8. Checklist de comandos y atajos útiles**
- Backend:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
php artisan test
```

- Frontend:

```bash
cd front
npm install
npm run dev
```

- Git básicos:

```bash
git checkout -b feature/notes-api
git add .
git commit -m "Implement notes endpoint"
git push origin feature/notes-api
```

**9. Qué esperan en la demo — cómo prepararte**
- Explica la arquitectura en 3 bloques: API (Laravel), lógica de negocio (Services/Repositories), UI (React).
- Muestra endpoints principales con Postman o Swagger.
- Prepárate para cambios en vivo: practicar el ejercicio 7 (agregar un campo) te prepara para pedir crear migración, actualizar Request validations, ajustar Resource y frontend.
- Sé capaz de: ejecutar tests, correr migraciones, crear un usuario profesor y mostrar la edición de notas en 5–10 minutos.

**10. Preguntas técnicas para practicar responder**
- ¿Por qué usaste Policies vs `spatie/laravel-permission`?
- ¿Cómo manejas validaciones complejas y errores en la API?
- ¿Qué trade-offs hiciste en el diseño (performance vs simplicidad)?
- ¿Cómo escalarías el sistema si hay muchos alumnos y notas?

**11. Plan de estudio sugerido (3 días ejemplo)**
- Día 1 (Backend foco): autenticar con Sanctum, migraciones, endpoints CRUD básicos, seeders.
- Día 2 (Tests + Authorization): escribir Feature tests, Policies, añadir `spatie` si lo decides.
- Día 3 (Frontend + Demo prep): React views, login, editar notas, practicar cambio en caliente y repasar preguntas.

**12. Recursos recomendados**
- Laravel docs: Authentication, Authorization, Eloquent, Testing.
- Sanctum quickstart.
- React docs: hooks, context, testing-library.
- spatie/laravel-permission package docs.

---
Si querés, puedo:
- Crear una checklist más detallada con tareas concretas y tiempo estimado.
- Generar una branch con un scaffold inicial (endpoints + seeders) para practicar.

