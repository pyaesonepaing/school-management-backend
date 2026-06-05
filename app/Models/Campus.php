<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'address',
        'status',
    ];



    public function rooms()
{
    return $this->hasMany(Room::class);
}

public function batches()
{
    return $this->hasMany(Batch::class);
}
public function schedules()
{
    return $this->hasMany(Schedule::class);
}
}
