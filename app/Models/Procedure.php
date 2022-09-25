<?php

namespace App\Models;

class Procedure extends GenericModel
{
    protected $table = 'procedures';
    protected $fillable = ['description', 'duration', 'value', 'dificulty'];
}
