<?php

namespace App\Models;

class CostumerAddress extends GenericModel
{
    protected $table = 'costumer_addresses';
    protected $fillable = [
        'costumer_id',
        'address_id',
    ];
}
