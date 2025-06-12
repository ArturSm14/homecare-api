<?php

namespace App\Models\Attendance;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Attendance extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $fillable = [
        'name',
        'phone',
        'symptoms',
        'address',
        'status',
        'number_protocol'
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attendance) {
            $attendance->number_protocol = self::generateNumberProtocol();
            $attendance->status = AttendanceStatus::PENDING;
        });
    }

    protected static function generateNumberProtocol(): string
    {
        $date = date('Ymd');
        $random = strtoupper(Str::random(4));
        $unique = substr(uniqid(), -4);

        return "PROT-{$date}-{$random}{$unique}";
    }

}
