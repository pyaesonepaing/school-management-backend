<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    //



    public function rooms()
{
    return $this->hasMany(Room::class);
}

public function batches()
{
    return $this->hasMany(Batch::class);
}
}
