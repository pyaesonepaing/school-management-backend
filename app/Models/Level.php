<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    //


    public function batches()
{
    return $this->hasMany(Batch::class);
}
}
