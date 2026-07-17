<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campus_id',
        'student_no',
        'gender',
        'dob',
        'address',
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
        return $this->belongsToMany(Batch::class, 'batch_students');
    }

    public function attendances()
{
    return $this->hasMany(
        Attendance::class
    );
}

}