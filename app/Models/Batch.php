<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    //


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
    return $this->belongsToMany(
        Student::class,
        'batch_students'
    );
}
}
