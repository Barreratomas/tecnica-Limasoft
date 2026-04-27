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

Ver `back/database/migrations` para la definición completa de tablas. Resumen:

- `users` — usuarios
- `roles` — Spatie roles
- `courses` — cursos
- `enrollments` — matrículas (único `(student_id, course_id)`)
- `grades` — notas (relacionadas a `enrollments`)

Decisión clave: `grades` depende de `enrollments`, garantizando integridad.
