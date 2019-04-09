<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $fillable = ['user_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
