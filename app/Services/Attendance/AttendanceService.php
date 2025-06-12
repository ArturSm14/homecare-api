<?php

namespace App\Services\Attendance;

use App\Repositories\Attendance\AttendanceRepository;

class AttendanceService
{
    protected AttendanceRepository $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function createAttendance(array $data)
    {
        try {
            return $this->attendanceRepository->create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function paginate(int $perPage = 15)
    {
        return $this->attendanceRepository->paginate($perPage);
    }
}
