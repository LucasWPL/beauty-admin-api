<?php

namespace App\Models;

class Job extends GenericModel
{
    protected $table = 'jobs';
    protected $fillable = ['time', 'costumer_id'];
}
