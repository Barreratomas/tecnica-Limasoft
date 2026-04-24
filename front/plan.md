# Sprints Frontend

---

## Sprint F1 — Setup y autenticación

**Objetivo:** app corriendo, login funcionando y rutas protegidas.

### Tarea F1.1 — Setup inicial

* Crear proyecto con Vite + React
* Instalar: react-router-dom, axios
* Configurar `VITE_API_URL`
* Definir estructura de carpetas

### Tarea F1.2 — Axios

* Instancia en `src/api/axios.js`
* Interceptor request (token)
* Interceptor response (401 global)

### Tarea F1.3 — AuthContext

* user, token, login, logout
* isAuthenticated, isLoading
* Persistencia en localStorage
* Validación con `/api/auth/me`

### Tarea F1.4 — useAuth

* Wrapper de AuthContext
* Error si se usa fuera del provider

### Tarea F1.5 — Router

* PrivateRoute
* RoleGuard
* Rutas en `src/router/index.jsx`
* Redirección por rol

### Tarea F1.6 — LoginPage

* Formulario
* Manejo de 401
* Redirección por rol

---

## Sprint F2 — API

**Objetivo:** encapsular llamadas.

### auth.js

```js
login(email, password)
logout()
me()
```

### courses.js

```js
getCourses()
getCourse(id)
createCourse(data)
updateCourse(id, data)
deleteCourse(id)
getCourseStudents(id)
enrollStudent(courseId, studentId)
unenrollStudent(enrollmentId)
```

### grades.js

```js
getGrade(enrollmentId)
updateGrade(enrollmentId, data)
```

### users.js

```js
getUsers(role?)
getUser(id)
createUser(data)
updateUser(id, data)
```

---

## Sprint F3 — UI

**Objetivo:** componentes reutilizables.

### Button

* Variantes: primary, secondary, danger

### Input

* label, error, type

### Table

* columns + data

### Alert

* success, error, warning

### Badge

* muestra rol

### Layout

* AppLayout
* Navbar
* Sidebar

---

## Sprint F4 — Alumno

**Objetivo:** ver cursos y notas.

### useCourses

* GET /api/courses

### StudentDashboard

* Lista cursos

### useGrades

* GET /api/enrollments/{id}/grade

### StudentCoursePage

* Nota o "Sin nota"

---

## Sprint F5 — Profesor

**Objetivo:** editar notas.

### TeacherDashboard

* Lista cursos

### TeacherCoursePage

* Tabla alumnos

### Edición

* Input 0–10
* PUT /grade

### Validación

* 0–10
* 2 decimales

---

## Sprint F6 — Admin

**Objetivo:** gestión completa.

### AdminDashboard

* Resumen

### CoursesPage

* CRUD cursos

### CourseFormPage

* Form + select profesor

### EnrollmentsPage

* Gestionar alumnos

### UsersPage

* Tabla + filtro

### UserFormPage

* Crear / editar
