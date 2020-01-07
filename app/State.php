<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'user_id'
    ];

    //
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
}
