<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
        'batch_id',
        'platform',
        'title',
        'meeting_link',
        'description',
        'is_active',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}