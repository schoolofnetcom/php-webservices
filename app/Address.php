<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $fillable = [
        'address',
        'city',
        'state',
        'zipcode'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
