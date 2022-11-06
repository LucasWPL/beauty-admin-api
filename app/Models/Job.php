<?php

namespace App\Models;

class Job extends GenericModel
{
    public const STATUS_PENDENTE = 'pendente';
    public const STATUS_FINALIZADO = 'finalizado';

    protected $table = 'jobs';
    protected $fillable = ['time', 'costumer_id'];
}
