Ejercicios Prácticos (Fácil → Difícil)

Warm-ups (15–30 min cada uno)

Objetivo: entender modelo básico. Crear modelos User, Course, Enrollment, Grade (migrations).
Pasos: crear migration, definir relaciones (belongsTo/hasMany). Tiempo: 20m. Éxito: correr migration y ver tablas.
Objetivo: endpoint simple. Implementar GET /courses que devuelva lista de cursos.
Pasos: route → controller → resource/transformer. Tiempo: 20m. Éxito: respuesta JSON con cursos.
Objetivo: autenticación minimal. Implementar login/register (token).
Pasos: crear endpoints, generar token (Sanctum/JWT). Tiempo: 30m. Éxito: obtener token y llamar endpoint protegido.


Básico (30–60 min cada uno)

CRUD de Course (admin). Añadir validaciones y FormRequest. Tiempo: 45m. Éxito: crear/editar/borrar con validación.
Vista alumno: GET /me/grades devuelve sus notas (usa Enrollment/Grade). Tiempo: 45m. Éxito: alumno ve solo sus notas.
Profesor actualiza nota: PUT /grades/{id} con permiso. Tiempo: 45m. Éxito: profesor asignado puede actualizar, otros no.


Intermedio / SOLID drills (45–90 min cada uno)

SRP refactor: sacar lógica de creación de curso del controller a CourseService.
Éxito: controller delega trabajo, tests unitarios apuntan al service.
OCP/Strategy: refactor para cálculo de nota final (p. ej. distinto cálculo por curso) usando Strategy pattern.
Éxito: añadir nueva regla sin modificar código existente.
Dependency Inversion: inyectar Repository interfaces en servicios y usar EloquentCourseRepository concreto.
Éxito: tests pueden mockear repositorios.
Drills de edición en vivo (5–20 min cada uno) — práctica para la demo

Añadir un campo a Course (ej.: credits) y exponerlo en la API. Pasos rápidos: migration, model fillable, controller validation, resource. Tiempo: 10m. Éxito: campo aparece en respuestas.
Cambiar validación: hacer title obligatorio y límite 100 chars. Tiempo: 5–10m. Éxito: request falla con 422 si inválido.
Ajuste en política: permitir edición de nota sólo si grade.course.professor_id == user.id. Tiempo: 10–15m. Éxito: test de permiso pasa/falla según caso.
Añadir endpoint pequeño: GET /courses/{id}/students que liste alumnos matriculados. Tiempo: 10–20m. Éxito: devuelve lista paginada.


Tests y CI (30–90 min)

Test feature: autenticar + profesor actualiza nota (happy + forbidden). Tiempo: 45m. Éxito: tests pasan.
GitHub Action simple que corre tests en push. Tiempo: 30–60m. Éxito: CI ejecuta tests.


Avanzado (90+ min)

Documentar API con OpenAPI/Swagger y exponer docs.
Docker-compose para levantar DB + app con script init (migrate+seed).
Optimización DB: añadir índice, medir query con eager loading para evitar N+1.