# Frontend — Documentación técnica

---

## 1. Estructura de carpetas

```
src/
├── api/
│   ├── axios.js
│   ├── auth.js
│   ├── courses.js
│   ├── enrollments.js
│   ├── grades.js
│   └── users.js
├── context/
│   └── AuthContext.jsx
├── hooks/
│   ├── useAuth.js
│   ├── useCourses.js
│   ├── useGrades.js
│   └── useUsers.js
├── components/
│   ├── ui/
│   │   ├── Button.jsx
│   │   ├── Input.jsx
│   │   ├── Table.jsx
│   │   ├── Badge.jsx
│   │   └── Alert.jsx
│   ├── layout/
│   │   ├── AppLayout.jsx
│   │   ├── Navbar.jsx
│   │   └── Sidebar.jsx
│   └── shared/
│       ├── PrivateRoute.jsx
│       └── RoleGuard.jsx
├── pages/
│   ├── auth/
│   │   └── LoginPage.jsx
│   ├── admin/
│   │   ├── AdminDashboard.jsx
│   │   ├── CoursesPage.jsx
│   │   ├── CourseFormPage.jsx
│   │   ├── UsersPage.jsx
│   │   ├── UserFormPage.jsx
│   │   └── EnrollmentsPage.jsx
│   ├── teacher/
│   │   ├── TeacherDashboard.jsx
│   │   └── TeacherCoursePage.jsx
│   └── student/
│       ├── StudentDashboard.jsx
│       └── StudentCoursePage.jsx
├── router/
│   └── index.jsx
└── utils/
    ├── roles.js
    └── formatters.js
```

---

## 2. Arquitectura de estado

El único estado global es la autenticación.

```js
{
  user: { id, name, email, role },
  token: string,
  login: async () => {},
  logout: () => {},
  isAuthenticated: boolean,
  isLoading: boolean
}
```

* El token se guarda en `localStorage`
* Se valida con `/api/auth/me` al iniciar
* Si es inválido → limpia estado y redirige a login

Hooks manejan estado local (`loading`, `error`, `data`)

---

## 3. Axios

```js
const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL
})

instance.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

instance.interceptors.response.use(
  res => res,
  err => {
    if (err.response?.status === 401) {
      localStorage.clear()
      window.location.href = '/login'
    }
    return Promise.reject(err)
  }
)
```

---

## 4. Rutas

```
/login
/admin
/admin/courses
/admin/users
/teacher
/teacher/courses/:id
/student
/student/courses/:id
```

* `PrivateRoute` → requiere login
* `RoleGuard` → valida rol

---

## 5. Contratos API

### Auth

```
POST /api/auth/login
```

### Student

```
GET /api/courses
GET /api/enrollments/{id}/grade
```

### Teacher

```
GET /api/courses
GET /api/courses/{id}/students
PUT /api/enrollments/{id}/grade
```

### Admin

```
GET /api/courses
POST /api/courses
PUT /api/courses/{id}
DELETE /api/courses/{id}

GET /api/users
POST /api/users
PUT /api/users/{id}

POST /api/courses/{id}/enroll
DELETE /api/enrollments/{id}
```

---

## 6. Flujos

### Alumno

* Ve cursos
* Ve su nota

### Profesor

* Ve cursos
* Edita notas

### Admin

* Gestiona cursos
* Gestiona usuarios
* Gestiona matrículas

---

## 7. Manejo de errores

| Código | Acción         |
| ------ | -------------- |
| 401    | Redirect login |
| 403    | Sin permisos   |
| 404    | No encontrado  |
| 422    | Validación     |
| 500    | Error genérico |

---

## 8. Decisiones

* Context sobre Redux
* Hooks por recurso
* Axios por interceptores
* Sin estado global innecesario
* React Router v6
