<?php

namespace App\Repositories\Interfaces;

use App\Models\Posts;

interface PostRepositoryInterface
{
    public function all():array;

    public function findPost(int $id): Posts;

    public function create($request): Posts;

    public function edit(int $id): Posts;

    public function update(int $id, $request): Posts;

    public function delete(int $id): bool;
}
