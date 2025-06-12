<?php

namespace App\Repositories\Attendance;

use App\Models\Attendance\Attendance;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository
{
    protected Attendance $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    public function findOrFail(int $id): ?Attendance
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Attendance
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
       $model = $this->model->findOrFail($id);
       if (!$model) {
         return false;
       }

       return $model->update($data);
    }

    public function delete($id): bool
    {
       $model = $this->model->findOrFail($id);
       if (!$model) {
         return false;
       }
       return $model->delete();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }
}
