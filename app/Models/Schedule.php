<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'shift_start',
        'shift_end',
        'break_start',
        'break_end',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
        'shift_start' => 'datetime',
        'shift_end' => 'datetime',
        'break_start' => 'datetime',
        'break_end' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
