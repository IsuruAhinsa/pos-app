<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract readonly class BaseRepository implements RepositoryInterface
{
    public function __construct(
        protected Model $model
    ) {}

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function find(int $recordId): Model
    {
        return $this->model->findOrFail($recordId);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function update(int $recordId, array $attributes): Model
    {
        $record = $this->find($recordId);
        $record->update($attributes);

        return $record;
    }

    public function delete(int $recordId): bool
    {
        return $this->model->destroy($recordId);
    }
}
