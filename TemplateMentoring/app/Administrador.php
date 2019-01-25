<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $table = 'tb_admins';
    protected $primaryKey = 'cd_admin';
    protected $fillable = [
        'nm_admin',
    ];

    public $regras = [
        'nm_admin' => 'bail|sometimes|min:5|max:100|required',
    ];

    public $mensagem = [
        'nm_admin.min' => 'Nome inferior ao tamanho mínimo',
        'nm_admin.max' => 'Nome superior ao tamanho máximo',
        'nm_admin.required' => 'Nome é obrigatorio'
    ];

}
