<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BatchStudent extends Pivot
{
    protected $table = 'batch_students';

    protected $fillable = [
        'batch_id',
        'student_id',
    ];
}