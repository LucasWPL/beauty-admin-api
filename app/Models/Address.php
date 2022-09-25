<?php

namespace App\Models;

class Address extends GenericModel
{
    protected $table = 'addresses';
    protected $fillable = [
        'addressDetail',
        'city',
        'state',
        'country',
        'CEP',
    ];
}
