<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    protected $table = 'tb_vendas';
    protected $primaryKey = 'cd_venda';
    protected $fillable = [
        'dt_venda',
        'fk_vendas_visitante',
        'cd_compra',
        'st_status',
        'qt_minutos_compra'
    ];
}
