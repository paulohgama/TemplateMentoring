<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Valor;
use Illuminate\Support\Facades\DB;

class ValorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $valor = DB::table('tb_valores')
                ->select('valor')
                ->limit(1)
                ->orderBy('created_at', 'desc')
                ->get();
        return View('admin.atendimento.create', compact('valor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->get('valor') != null){
            $request->merge(['valor' => str_replace('.','',$request->get('valor'))]);
            $request->merge(['valor' => str_replace(',','.',$request->get('valor'))]);
        }
        $regras = [
            'valor' => 'bail|sometimes|required|numeric|between:0.01,999.99'
        ];
        $mensagens = [
            'valor.required' => 'Valor obrigatorio',
            'valor.number' => 'Valor do minuto deve ser um número',
            'valor.between' => 'Valor do minuto deve estar entre 0.01 e 1000 reais'
        ];
        $this->validate($request, $regras, $mensagens);
        $valor = new \App\Valor;
        $valor->valor = $request->valor;
        $date = date('YmdHis');
        $time = date("H:i:s",strtotime($date));
        $date = date("Y-m-d",strtotime($date));
        $valor->dt_mudanca = $date;
        $valor->hr_mudanca = $time;
        if ($valor->save()) {
            return back()->with(['Valor' => $valor->valor, 'message' => 'Valor cadastrado com sucesso!']);
        }
        return back()->withErrors('Erro', 'Deu erro');
    }
}
