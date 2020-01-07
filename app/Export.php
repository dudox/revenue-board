<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    //
    protected $fillable = [
        'type',
        'user_id',
        'batch_id',
        'denomination_id',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function batch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function denomination()
    {
        return $this->hasOne(Denomination::class, 'id', 'denomination_id');
    }


}
