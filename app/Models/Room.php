<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id',
        'name',
        'capacity',
        'status',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
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