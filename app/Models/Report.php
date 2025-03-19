<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'total_present',
        'total_absent',
        'total_late',
        'total_leave',
        'total_work_hours',
        'total_overtime_hours',
        'active_shifts'
    ];

    protected $casts = [
        'report_date' => 'date',
        'total_present' => 'integer',
        'total_absent' => 'integer',
        'total_late' => 'integer',
        'total_leave' => 'integer',
        'total_work_hours' => 'float',
        'total_overtime_hours' => 'float',
        'active_shifts' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
