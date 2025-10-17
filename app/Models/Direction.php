<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = [
        'diary_id', 'step_number', 'description',
    ];

    public function diary()
    {
        return $this->belongsTo(Diary::class);
    }

}
