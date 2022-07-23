<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costumer extends Model
{
    use HasFactory;

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
