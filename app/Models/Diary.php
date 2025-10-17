<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $fillable = [
        'user_id', 'title', 'difficulty', 'make_time', 'ingredients', 'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function directions()
    {
        return $this->hasMany(Direction::class)->orderBy('step_number');
    }

    // convenience: get average rating later if you add ratings
    public function averageRating()
    {
        return $this->hasMany(DiaryRating::class)->avg('rating') ?: 0;
    }
}
