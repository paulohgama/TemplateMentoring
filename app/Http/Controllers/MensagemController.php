<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Mensagem;

class MensagemController extends Controller
{
    public function store(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $mensagem = new \App\Mensagem;
        $mensagem->fk_mensagem_atendimento = $request->get('atendimento');
        $mensagem->ds_mensagem = $request->get('mensagem');
        $mensagem->cd_msgporconsultor = $request->get('msgpor');
        $mensagem->save();
    }
}
