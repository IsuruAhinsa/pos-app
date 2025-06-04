<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface
{
    /**
     * Retrieve all records from the repository
     */
    public function getAll(): Collection;

    /**
     * Find a record by its unique identifier
     */
    public function find(int $recordId): mixed;

    /**
     * Create a new record with the given data
     *
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): mixed;

    /**
     * Update an existing record with the given data
     *
     * @param  array<string, mixed>  $attributes
     */
    public function update(int $recordId, array $attributes): mixed;

    /**
     * Delete a record by its unique identifier
     */
    public function delete(int $recordId): bool;
}
