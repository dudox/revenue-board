<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $fillable = [
        'code',
        'amount',
        'batch_id',
        'denomination_id',
        'amount',
        'status',
    ];

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function denomination()
    {
        return $this->hasOne(Denomination::class, 'id', 'denomination_id');
    }

    public function entry()
    {
        return $this->hasOne(Card::class, 'code', 'code');
    }
}
