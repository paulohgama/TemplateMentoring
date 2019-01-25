<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferencias extends Model
{
    protected $fillable = [
        'dt_periodo_pago', 'vl_total', 'vl_comissao', 'qnt_atendimento', 'fk_transferencia_consultor', 'dt_pagamento', 'hr_pagamento'
    ];
    protected $primaryKey = 'cd_tranferencia';
    protected $table = 'tb_transferencias';
}
