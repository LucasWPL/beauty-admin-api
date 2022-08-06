<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProcedures extends Model
{
    use HasFactory;

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
