<?php

namespace App\Repositories\Attendance;

use App\Enums\AttendanceStatus;
use App\Models\Attendance\Attendance;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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
    
    public function countByStatus(): array
    {
        $counts = [];
        
        foreach (AttendanceStatus::cases() as $status) {
            $counts[$status->value] = 0;
        }
        
        $results = $this->model
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        foreach ($results as $result) {
            $counts[$result->status->value] = $result->total;
        }
        
        return $counts;
    }
}
