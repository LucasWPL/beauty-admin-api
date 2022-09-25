<?php

namespace App\Models;

class JobProcedures extends GenericModel
{
    protected $table = 'job_procedures';
    protected $fillable = [
        'job_id',
        'procedure_id',
        'description',
        'dificulty',
        'duration',
        'value',
    ];
}
