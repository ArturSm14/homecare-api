<?php

namespace App\Routes\Attendance;

use App\Http\Controllers\Attendance\AttendanceController;
use Illuminate\Support\Facades\Route;

class AttendanceRoutes
{
    public static function routes()
    {
       Route::prefix('attendances')
           ->group(function () {
               Route::post('/', [AttendanceController::class, 'store'])->name('attendance.store');
               Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
               Route::get('/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
               Route::put('/{id}', [AttendanceController::class, 'update'])->name('attendance.update');
               Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
           });
    }
}
