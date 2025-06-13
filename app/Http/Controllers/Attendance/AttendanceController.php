<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Http\Responses\ApiResponse;
use App\Jobs\SendWhatsappProtocolJob;
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
            $attendance = $this->attendanceService->register($request->validated());

            if (!empty($attendance->phone)) {
                SendWhatsappProtocolJob::dispatch(
                    $attendance->phone,
                    $attendance->number_protocol,
                    $attendance->created_at->format('d/m/Y H:i:s')
                );
            }
            
            return ApiResponse::created(new AttendanceResource($attendance));
        } catch (\Exception $e) {
            return ApiResponse::error($e);
        }
    }

    public function show($id)
    {
        try {
            $attendance = $this->attendanceService->findOrFail($id);
            return ApiResponse::success(new AttendanceResource($attendance));
        } catch (\Exception $e) {
            return ApiResponse::error($e);
        }
    }

    public function update(UpdateAttendanceRequest $request, $id)
    {
        try {
            $attendance = $this->attendanceService->update($id, $request->validated());
            return ApiResponse::success(new AttendanceResource($attendance));            
        } catch (\Exception $e) {
            return ApiResponse::error($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->attendanceService->delete($id);
            return ApiResponse::success();
        } catch (\Exception $e) {
            return ApiResponse::error($e);
        }
    }
    
}
