<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Depoimentos;

class DepoimentosController extends Controller
{
    public function store(Request $request){
        $regras = [
            'nt_depoimento' => 'bail|sometimes|required',
            'ds_depoimento' => 'bail|sometimes|required|min:5|max:255'
        ];
        $mensagens = [
            'nt_depoimento.required' => 'Nota obrigatoria',
            'ds_depoimento.required' => 'Depoimento obrigatorio',
            'ds_depoimento.min' => 'Depoimento de tamanho insuficiente',
            'ds_depoimento.max' => 'Depoimento de tamanho superior ao permitido'
        ];
        $this->validate($request, $regras, $mensagens);
        $depoimentos = new \App\Depoimentos;
        $depoimentos->fk_depoimento_consultor = $request->get('fk_depoimento_consultor');
        $depoimentos->fk_depoimento_visitante = $request->get('fk_depoimento_visitante');
        $depoimentos->dt_depoimento = date('Y-m-d');
        $depoimentos->nt_depoimento = $request->get('nt_depoimento');
        $depoimentos->ds_depoimento = $request->get('ds_depoimento');
        $depoimentos->save();
        return redirect('/');
    }
}
