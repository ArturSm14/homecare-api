<?php

namespace App\Services\Attendance;

use App\Models\Attendance\Attendance;
use App\Repositories\Attendance\AttendanceRepository;

class AttendanceService
{
    protected AttendanceRepository $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function findOrFail(int $id) : ?Attendance
    {
        return $this->attendanceRepository->findOrFail($id);
    }

    public function register(array $data): Attendance
    {
        try {
            return $this->attendanceRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(int $id, array $data): Attendance
    {
        try {
            $updated = $this->attendanceRepository->update($id, $data);
            if (!$updated) {
                throw new \Exception('Falha ao atualizar o atendimento');
            }
            return $this->findOrFail($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->attendanceRepository->delete($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function paginate(int $perPage = 15)
    {
        return $this->attendanceRepository->paginate($perPage);
    }
}
