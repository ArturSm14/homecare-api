<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Attendance extends Model
{

    protected $fillable = [
        'name',
        'phone',
        'address',
        'number_protocol'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attendance) {
            $attendance->number_protocol = self::generateNumberProtocol();
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
