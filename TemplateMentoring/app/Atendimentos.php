<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atendimentos extends Model
{
    protected $table = 'tb_atendimentos';
    protected $primaryKey = 'cd_atendimento';
    protected $fillable = [
        'fk_atendimento_consultor',
        'fk_atendimento_visitante',
        'dt_atendimento',
        'hr_inicio',
        'hr_termino',
        'status_transacao',
        'tp_total'
    ];
}
