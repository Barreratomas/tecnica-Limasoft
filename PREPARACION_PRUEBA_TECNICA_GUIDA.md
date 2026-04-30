# Guía de estudio para la prueba técnica — Limasoft

Breve: esta guía lista los conceptos a dominar, ejercicios prioritarios, checklist del repo y preparación para la demo.

**Qué Estudiar**
- **POO:** clases, herencia, composición, interfaces/traits, visibilidad, inmutabilidad.
- **SOLID:** Single Responsibility, Open/Closed, Liskov, Interface Segregation, Dependency Inversion (ejemplos y cuándo aplicarlos).
- **Patrones de diseño:** Repository, Service, Factory, Strategy, Observer/Events, DTO/Mapper, Adapter.
- **Bases de datos:** modelado relacional (normalización, joins, índices, transacciones), NoSQL (modelado de documentos, embedding vs referencing, atomicidad limitada).
- **Laravel / Django (backend):** rutas, controllers, models/ORM, migrations, seeders, validaciones (FormRequests/serializers), policies/gates, autenticación (Sanctum/JWT), manejo de excepciones.
- **REST API:** recursos, status codes, paginación, filtros, validación, documentación (OpenAPI/Swagger), versionado.
- **Control de roles/permiso:** middleware, policies, roles simples (Alumno/Profesor/Administrador), pruebas de acceso.
- **React (frontend):** componentes funcionales, hooks (`useState`, `useEffect`, `useContext`), formularios controlados, manejo de peticiones (fetch/axios), routing, control de vistas según roles.
- **Testing:** tests unitarios para servicios/lógicas, tests de integración/feature para endpoints, pruebas básicas de componentes React (render y eventos).
- **Buenas prácticas:** estructura clara del proyecto, separación de responsabilidades, validaciones en servidor, manejo de errores claro, commits atómicos, README útil.
- **Despliegue & Docker:** Dockerfile básico, variables de entorno, ejecutar migraciones, despliegue mínimo (Heroku/DigitalOcean/VPS) opcional.

**Ejercicios prácticos (prioridades)**
1. **API y modelo de datos (backend)**
   - Implementar modelos: `User`, `Course`, `Enrollment` (matrícula), `Grade`.
   - Endpoints: login/register, listar cursos, ver notas de alumno, CRUD cursos (admin), asignar profesor, profesor actualizar nota.
   - Migrations + seeders con datos de prueba (alumnos, profesores, cursos, matrículas).
2. **Autenticación y roles**
   - Implementar auth (token-based / session) y middleware de roles.
   - Policies para que sólo el profesor asignado pueda editar notas de sus alumnos.
3. **Frontend mínimo (React)**
   - Login, vista alumno (ver sus notas), vista profesor (editar notas), vista admin (gestionar cursos).
   - Manejo de token y rutas protegidas.
4. **Pruebas**
   - Tests de feature: autenticar, acceder a endpoint protegido, profesor actualiza nota, alumno no puede editar.
   - Tests unitarios para una clase de servicio clave.
5. **Extras que suman puntos**
   - Documentar la API (OpenAPI/Swagger) o agregar Postman collection.
   - Integración CI que corre tests (GitHub Actions simple).
   - Deploy mínimo o script Docker-compose para levantar la app.

**Checklist para el repositorio antes de entregar**
- **README:** instrucciones claras para instalar, migrar, seedear y ejecutar backend y frontend.
- **.env.example:** variables necesarias explicadas.
- **Migrations & Seeders:** incluidas y probadas.
- **Tests:** al menos 3-5 pruebas relevantes que pasen.
- **Documentación de API / ejemplos:** curl / Postman / endpoints principales.
- **Commits:** historial coherente y mensajes claros.
- **Demo notes:** comandos rápidos para levantar entorno y restaurar datos (migrate/seed).

**Preparación para la demo (qué mostrar y practicar)**
- Poder levantar la app en <5 minutos con las instrucciones del README.
- Mostrar: login como admin/profesor/alumno; crear curso; asignar profesor; profesor editar nota; alumno ver nota.
- Estar preparado para cambios sencillos en vivo: añadir un campo a `Course`, cambiar una validación, o exponer un campo extra en la API.
- Tener a mano comandos útiles:

```bash
# Backend (Laravel ejemplo)
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve

# Frontend (React ejemplo)
cd front
npm install
npm run dev
```

**Cronograma sugerido (3 días)**
- Día 1: Modelo de datos, autenticación, endpoints básicos, migrations/seeders.
- Día 2: Roles/policies, endpoints protegidos, pruebas básicas, README inicial.
- Día 3: Frontend mínimo, documentación API, pulir README, preparar demo.

**Recursos recomendados (rápido)**
- Documentación oficial de Laravel / Django
- React docs (hooks & routing)
- Laracasts (Laravel) / MDN (JS)
- Artículos sobre SOLID y patrones (resúmenes/práctica)


---
Si querés, lo agrego al README del repo, creo un `Postman` pequeño o te genero los comandos `curl` para los endpoints principales. ¿Qué preferís que haga ahora?