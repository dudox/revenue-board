<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    //
    protected $fillable = [
        'code',
        'batch_id',
        'denomination_id',
        'state_id',
        'customer_phone',
        'customer_name',
        'session_id',
        'expires',
        'cost',
    ];

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function card()
    {
        return $this->hasOne(Card::class, 'code', 'code');
    }
}
