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
        'active_shifts',
    ];

    protected $casts = [
        'report_date' => 'date',
        'total_work_hours' => 'decimal:2',
        'total_overtime_hours' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 