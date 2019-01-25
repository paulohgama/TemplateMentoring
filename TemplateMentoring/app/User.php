<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable;
// use Illuminate\Auth\Authenticatable as AuthenticableTrait;

// class User extends \Eloquent implements Authenticatable
// {
// use AuthenticableTrait;
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_usuarios';
    protected $primaryKey = 'cd_usuario';
    protected $fillable = [
        'email', 'password', 'cd_usuario_fk', 'cd_role', 'remember_token', 'status'
    ];
    protected $hidden = [
        'password'
    ];

    protected $regras;

    public $mensagens = [
        'email.required' => 'E-mail obrigatorio',
        'email.min' => 'E-mail de tamanho insuficiente',
        'email.max' => 'E-mail de tamanho superior ao permitido',
        'email.email' => 'E-mail invalido',
        'email.unique' => 'E-mail já cadastrado',
        'email.exists' => 'E-mail login incorreto',
        'password.min' => 'Senha tamanho insuficiente',
        'password.max' => 'Senha de tamanho superior ao permitido',
        'password.required' => 'Senha obrigatoria',
        'password.confirmed' => 'Senhas não coecidem',
    ];

    public function Regras($tipo = 'insert')
    {
        switch ($tipo)
        {
            case 'insert':
                $regras = [
                    'email' => 'bail|sometimes|required|min:5|max:100|email|unique:tb_usuarios,email',
                    'password' => 'bail|sometimes|required|min:8|max:100|confirmed'
                ];
            break;
            case 'update':
                $regras = [
                    'email' => 'bail|sometimes|required|min:5|max:100|email',
                    'password' => 'bail|sometimes|required|min:8|max:100|confirmed'
                ];
            break;
            case 'login':
                 $regras = [
                    'email' => 'bail|sometimes|required|exists:tb_usuarios,email',
                    'password' => 'bail|sometimes|required'
                ];
            break;
            default:
                $regras = [];
            break;
        }
        return $regras;
    }
}
