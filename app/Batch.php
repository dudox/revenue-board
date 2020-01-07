<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'name',
        'description',
        'state_id',
    ];
    //
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function denominations()
    {
        return $this->hasMany(Denomination::class)->with('duration')->orderBy('cost', 'ASC');
    }
}
