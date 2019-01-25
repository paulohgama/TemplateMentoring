<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $table = 'tb_visitantes';
    protected $primaryKey = 'cd_visitante';
    protected $fillable = [
        'nm_visitante',
        'qt_segundos'
    ];

    public $regras = [
        'nm_visitante'=> 'bail|sometimes|required|min:5|max:100',
        'qt_segundos' => 'bail|sometimes|required|digits:7'
    ];

    public $mensagens = [
        'nm_visitante.required' => 'Nome é obrigatório',
        'nm_visitante.min' => 'O nome contém menos caracteres que o mínimo permitido',
        'nm_visitante.max' => 'O nome contém mais caracteres que o máximo permitido',
        'qt_segundos.required' => 'Quantidade de minutos é obrigatória'
    ];
}
