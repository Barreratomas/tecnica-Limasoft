<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findAll(?string $role = null): Collection;
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(int $id, array $data): User;
}