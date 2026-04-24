##  Arquitectura

El backend sigue una arquitectura en capas con separación clara de responsabilidades:

```
app/
├── Http/
│   ├── Controllers/     # Reciben request, delegan al Service, devuelven response
│   ├── Requests/        # Validaciones (Form Requests)
│   └── Policies/        # Control de acceso
├── Services/            # Lógica de negocio
├── Repositories/        # Acceso a datos
├── Models/              # Entidades Eloquent
└── Interfaces/          # Contratos
```

### Principios aplicados (SOLID)

* **S (Single Responsibility)**: cada clase tiene una única responsabilidad
* **O (Open/Closed)**: extensible sin modificar código existente
* **L (Liskov)**: implementaciones intercambiables
* **I (Interface Segregation)**: interfaces específicas
* **D (Dependency Inversion)**: dependencia de abstracciones

---

##  Modelo de datos

### Tablas

#### users

| Columna    | Tipo         | Descripción         |
| ---------- | ------------ | ------------------- |
| id         | bigint (PK)  | Identificador único |
| name       | varchar(255) | Nombre              |
| email      | varchar(255) | Único               |
| password   | varchar(255) | Hash bcrypt         |
| created_at | timestamp    | Creación            |
| updated_at | timestamp    | Actualización       |

#### roles (Spatie)

| Columna    | Tipo         |
| ---------- | ------------ |
| id         | bigint (PK)  |
| name       | varchar(125) |
| guard_name | varchar(125) |

#### courses

| Columna     | Tipo         | Descripción |
| ----------- | ------------ | ----------- |
| id          | bigint (PK)  |             |
| name        | varchar(255) |             |
| description | text         | nullable    |
| teacher_id  | bigint (FK)  | → users     |
| created_at  | timestamp    |             |
| updated_at  | timestamp    |             |

#### enrollments

| Columna     | Tipo        | Descripción |
| ----------- | ----------- | ----------- |
| id          | bigint (PK) |             |
| student_id  | bigint (FK) | → users     |
| course_id   | bigint (FK) | → courses   |
| enrolled_at | date        |             |
| created_at  | timestamp   |             |
| updated_at  | timestamp   |             |

**Restricción única:** `(student_id, course_id)`

#### grades

| Columna       | Tipo         | Descripción   |
| ------------- | ------------ | ------------- |
| id            | bigint (PK)  |               |
| enrollment_id | bigint (FK)  | → enrollments |
| value         | decimal(4,2) | 0.00 – 10.00  |
| updated_by    | bigint (FK)  | → users       |
| notes         | text         | nullable      |
| created_at    | timestamp    |               |
| updated_at    | timestamp    |               |

### Decisión clave

`grades` depende de `enrollments`, no de `(student_id, course_id)`.

Esto garantiza integridad estructural: no puede existir una nota sin matrícula previa.

---

##  Roles y permisos

### Matriz

| Acción             | Alumno | Profesor | Admin |
| ------------------ | ------ | -------- | ----- |
| Ver cursos propios | ✅      | —        | —     |
| Ver notas propias  | ✅      | —        | —     |
| Ver alumnos        | —      | ✅        | —     |
| Ver notas alumnos  | —      | ✅        | —     |
| Editar notas       | —      | ✅        | —     |
| Crear cursos       | —      | —        | ✅     |
| Asignar profesor   | —      | —        | ✅     |
| Registrar usuarios | —      | —        | ✅     |
| Listar usuarios    | —      | —        | ✅     |

Control implementado con **Policies**.

---


---

##  Autenticación

* Basada en **Sanctum (API tokens)**
* Stateless (sin sesiones)
* Token enviado en cada request
* Logout revoca token