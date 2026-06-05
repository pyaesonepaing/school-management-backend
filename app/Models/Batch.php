<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'level_id',
        'campus_id',
        'room_id',
        'batch_name',
        'batch_code',
        'max_students',
        'start_date',
        'end_date',
        'status',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'batch_students');
    }
    public function schedules()
{
    return $this->hasMany(Schedule::class);
}

public function meeting()
{
    return $this->hasOne(Meeting::class);
}
}