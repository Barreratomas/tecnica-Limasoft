##  Endpoints

### Auth

```
POST   /api/auth/login
POST   /api/auth/logout
GET    /api/auth/me
```

### Courses

```
GET    /api/courses
POST   /api/courses
GET    /api/courses/{id}
PUT    /api/courses/{id}
DELETE /api/courses/{id}
```

### Enrollments

```
GET    /api/courses/{id}/students
POST   /api/courses/{id}/enroll
DELETE /api/enrollments/{id}
```

### Grades

```
GET    /api/enrollments/{id}/grade
PUT    /api/enrollments/{id}/grade
```

### Users

```
GET    /api/users
POST   /api/users
GET    /api/users/{id}
PUT    /api/users/{id}
```

**Header:**

```
Authorization: Bearer {token}
```

Swagger / OpenAPI

- UI: `/api/documentation` (ver `back/config/l5-swagger.php`)
- Archivo JSON generado: `back/storage/api-docs/api-docs.json`

Ejemplo: para ver la documentación en tu entorno local abrir:

```
http://localhost:8000/api/documentation
```
