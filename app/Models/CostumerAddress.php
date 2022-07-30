<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostumerAddress extends Model
{
    use HasFactory;

    protected $table = 'costumer_addresses';
    protected $fillable = [
        'costumer_id',
        'address_id',
    ];
}
