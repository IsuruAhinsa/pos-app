<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all records from the repository
     *
     * @return Collection Collection of all records
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a record by its unique identifier
     *
     * @param  int  $id  ID of the record to find
     * @return Model|null The found model or null if not found
     */
    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Create a new record with the given data
     *
     * @param  array<string, mixed>  $data  Data to create the record with
     * @return Model The created model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing record with the given data
     *
     * @param  int  $id  ID of the record to update
     * @param  array<string, mixed>  $data  Data to update the record with
     * @return bool Whether the update was successful
     */
    public function update(int $id, array $data): bool
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->update($data);
        }

        return false;
    }

    /**
     * Delete a record by its unique identifier
     *
     * @param  int  $id  ID of the record to delete
     * @return bool Whether the deletion was successful
     */
    public function delete(int $id): bool
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->delete();
        }

        return false;
    }

    /**
     * Find a record by a specific field value
     *
     * @param  string  $field  The field to search by
     * @param  mixed  $value  The value to search for
     * @return Model|null The found model or null if not found
     */
    public function findBy(string $field, mixed $value): ?Model
    {
        return $this->model->where($field, $value)->first();
    }

    /**
     * Get all records matching a specific field value
     *
     * @param  string  $field  The field to filter by
     * @param  mixed  $value  The value to filter for
     * @return Collection Collection of matching records
     */
    public function getWhere(string $field, mixed $value): Collection
    {
        return $this->model->where($field, $value)->get();
    }
}
