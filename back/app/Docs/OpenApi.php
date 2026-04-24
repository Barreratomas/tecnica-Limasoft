<?php

namespace App\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Academic Grades API",
    version: "1.0.0",
    description: "API para gestión de cursos, matrículas y notas"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "Bearer"
)]
class OpenApi
{
}