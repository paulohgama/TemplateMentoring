<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'tb_contatos';
    protected $primaryKey = 'cd_contato';
    protected $fillable = [
        'nm_contato',
        'nm_email',
        'cd_celular',
        'ds_mensagem'
    ];

    public $regras = [
        'nm_contato' => 'bail|sometimes|required|min:5|max:100',
        'nm_email' => 'bail|sometimes|required|email|max:100',
        'cd_celular' => 'bail|sometimes|required|max:15',
        'ds_mensagem' => 'bail|sometimes|required|min:5|max:1500'
    ];

    public $mensagens = [
        'nm_contato.required' => 'Nome é obrigatório',
        'nm_contato.min' => 'O nome contém menos caracteres que o mínimo permitido',
        'nm_contato.max' => 'O nome contém mais caracteres que o máximo permitido',
        'nm_email.required' => 'O email é obrigatório',
        'nm_email.email' => 'Email inválido',
        'nm_email.max' => 'O email contém mais caracteres que o máximo permitido',
        'cd_celular.required' => 'O número de celular é obrigatório',
        'cd_celular.required' => 'O número de celular contém mais digitos que o máximo permitido',
        'ds_mensagem.required' => 'A mensagem é obrigatória',
        'ds_mensagem.min' => 'A mensagem contém menos caracteres que o mínimo permitido',
        'ds_mensagem.max' => 'A mensagem contém mais caracteres que o máximo permitido'
    ];
}
