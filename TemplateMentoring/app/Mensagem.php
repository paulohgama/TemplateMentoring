<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'tb_mensagens';
    protected $primaryKey = 'cd_mensagem';
    protected $fillable = [
        'fk_mensagem_atendimento',
        'ds_mensagem',
        'cd_msgporconsultor'
    ];
}
