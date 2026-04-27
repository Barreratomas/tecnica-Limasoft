#  Documentación técnica



##  Descripción general

Sistema de gestión de notas académicas con tres roles diferenciados: **administrador**, **profesor** y **alumno**.

Expone una API REST construida en **Laravel** con autenticación *stateless* mediante **Sanctum** y control de permisos usando **Spatie Laravel Permission**.

El frontend en **React** consume la API y renderiza vistas adaptadas según el rol del usuario autenticado.

---

## Stack tecnológico

**Backend**

* Laravel 11
* PHP 8.2
* Laravel Sanctum
* Spatie Laravel Permission


**Base de datos**

* MySQL 8

**Infraestructura**

* Docker Compose (app, mysql, nginx)

**Testing**

* PHPUnit (feature tests)

**Documentación API**

* Swagger / OpenAPI (darkaonline/l5-swagger)


---

##  Setup

```bash
git clone https://github.com/Barreratomas/tecnica-Limasoft.git
cd tecnica-Limasoft

docker compose up -d

docker compose exec app composer install
docker compose exec app npm install

cp .env.example .env
docker compose exec app php artisan key:generate

docker compose exec app php artisan migrate --seed

docker compose exec app php artisan test
```

**Servicios**

* API: [http://localhost:8000/api](http://localhost:8000/api)
* Frontend: [http://localhost:5173](http://localhost:5173)
