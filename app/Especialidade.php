<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'tb_especialidades';
    protected $primaryKey = 'cd_especialidade';
    protected $fillable = [
        'nm_especialidade', 'created_at'
    ];
}
