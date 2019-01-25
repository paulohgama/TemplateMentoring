<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EspecialidadeConsultor extends Model
{
    protected $table = 'tb_especialidades_consultores';
    protected $fillable = [
        'fk_especialidade_consultor',
        'fk_consultor_especialidade'
    ];
}
