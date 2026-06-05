<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
    'batch_id',
    'teacher_id',
    'campus_id',
    'room_id',

    'day_of_week',

    'start_time',
    'end_time',

    'start_date',
    'end_date',

    'status',
];

public function batch()
{
    return $this->belongsTo(Batch::class);
}

public function teacher()
{
    return $this->belongsTo(Teacher::class);
}

public function campus()
{
    return $this->belongsTo(Campus::class);
}

public function room()
{
    return $this->belongsTo(Room::class);
}

public function attendances()
{
    return $this->hasMany(
        Attendance::class
    );
}

}
