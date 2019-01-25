<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultor extends Model
{
    protected $table = 'tb_consultores';
    protected $primaryKey = 'cd_consultor';
    protected $fillable = [
        'nm_consultor',
        'cd_cpf',
        'dt_nascimento',
        'ic_sexo',
        'cd_celular',
        'sg_estado',
        'nm_cidade',
        'ds_observacao',
        'ds_consultor',
        'status',
        'dt_login',
        'img_consultor',
        'qt_creditos'
    ];
    public $regras = [
        'nm_consultor' => 'bail|sometimes|required|min:5|max:100',
        'ds_consultor' => 'bail|max:1500',
        'ds_observacao' => 'bail|max:300',
        'status' => 'sometimes|required',
        'img_consultor' => 'bail|sometimes|image|required',
        'qt_creditos' => 'bail|sometimes|required',
    ];

    public $mensagens = [
        'nm_consultor.required' => 'Nome obrigatorio',
        'nm_consultor.min' => 'Nome muito pequeno',
        'nm_consultor.max' => 'Nome muito grande',
        'ds_consultor.max' => 'Descrição muito grande',
        'ds_observacao.max' => 'Observação muito grande',
        'status.required' => 'Status obrigatorio',
        'img_consultor.image' => 'Imagem invalida',
        'img_consultor.required' => 'Imagem obrigatoria',
        'qt_creditos.required' => 'Quantidade de Creditos obrigatorio',
    ];
}
