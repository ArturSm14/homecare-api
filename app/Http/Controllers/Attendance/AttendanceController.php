<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Http\Responses\ApiResponse;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $attendances = $this->attendanceService->paginate($perPage);

        return AttendanceResource::collection($attendances);
    }

    public function store(StoreAttendanceRequest $request)
    {
        try {
            $attendance = $this->attendanceService->createAttendance($request->validated());
            return ApiResponse::created(new AttendanceResource($attendance));
        } catch (\Exception $e) {
            return ApiResponse::error($e);
        }
    }
}
