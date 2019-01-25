<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depoimentos extends Model
{
    protected $table = 'tb_depoimentos';
    protected $primaryKey = 'cd_depoimento';
    protected $fillable = [
        'fk_depoimento_consultor',
        'fk_depoimento_visitante',
        'dt_depoimento',
        'nt_depoimento',
        'ds_depoimento'
    ];
}
