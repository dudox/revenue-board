<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    //
    protected $fillable = [
        'cost',
        'batch_id',
        'progress',
        'amount',
        'description',
        'identifier',
        'duration_id',
    ];

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function duration()
    {
        return $this->hasOne(Duration::class, 'id', 'duration_id');
    }
}
