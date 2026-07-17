<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{

    use HasFactory;

     protected $fillable = [
        'user_id',
        'campus_id',
        'teacher_no',
        'qualification',
        'joining_date',
        'bio',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'teacher_id');
    }
    public function schedules()
{
    return $this->hasMany(Schedule::class);
}
}
