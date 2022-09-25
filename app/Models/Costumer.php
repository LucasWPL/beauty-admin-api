<?php

namespace App\Models;

class Costumer extends GenericModel
{
    protected $table = 'costumers';
    protected $fillable = [
        'name',
        'phone',
        'birth_date',
        'cpf',
        'is_recommendation',
        'note',
    ];
}
