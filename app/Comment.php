<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body',
        'user_id',
        'video_url',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
