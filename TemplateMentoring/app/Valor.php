<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valor extends Model
{
    protected $table = 'tb_valores';
    protected $primaryKey = 'cd_valor';
    protected $fillable = [
        'valor',
        'dt_mudanca'
    ];
}
