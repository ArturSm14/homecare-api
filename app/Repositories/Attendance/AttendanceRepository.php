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

    public function create(array $data): Attendance
    {
        return $this->model->create($data);
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }
}
