<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class Repository
{
    /**)
     * avoid boilerplate code in repositories
    */
    public function __construct(protected Model $model) {}

    public function model(): Model
    {
        return $this->model;
    }

    public function query(): Builder
    {
        return $this->model->query();
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], array|string $relations = []): LengthAwarePaginator
    {
        return $this->query()->with($relations)->paginate($perPage, $columns);
    }

    public function find(int|string $id, array $columns =['*'], array|string $relations = []): ?Model
    {
        return $this->query()->with($relations)->find($id, $columns);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
