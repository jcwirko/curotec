<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Insert new object in DB (A specific entity)
     *
     * @param  mixed $model
     * @return void
     */
    public function save(Model $model)
    {
        $model->save();
        return $model;
    }

    /**
     * Get all records from DB (A specific entity)
     *
     * @return void
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * get: Get a record by ID from DB (A specific entity)
     *
     * @param  mixed $id
     * @return Model
     */
    public function get(int $id): Model | null
    {
        return $this->model->findOrFail($id);
    }

    /**
     * destroy: Destroy an object by ID from DB (A specific entity)
     *
     * @param  mixed $id
     * @return int
     */
    public function destroy(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * Get paginated records from DB
     *
     * @param  int $rowsPerPage
     * @param  string|null $orderBy
     * @param  string $order
     * @return LengthAwarePaginator
     */
    public function paginate(int $rowsPerPage, string|null $orderBy = null, string $order = 'ASC'): LengthAwarePaginator
    {
        $q = $this->model;

        if (!is_null($orderBy)) {
            $q = $q->orderBy($orderBy, $order);
        }

        return $q->paginate($rowsPerPage);
    }
}
