<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Atendimentos;
use App\Transferencias;
use Illuminate\Support\Facades\Auth;
use App\Consultor;

class TransferenciasConsultorController extends Controller
{
    public function index(Request $request)
    {
        $consultor = Consultor::find(Auth::user()->cd_usuario_fk);
        $atendimentos = Atendimentos::where('fk_atendimento_consultor', Auth::user()->cd_usuario_fk)->where('vl_total', '>', 0)->orderBy('dt_atendimento', 'desc');
        $transferencia = Transferencias::where('fk_transferencia_consultor', Auth::user()->cd_usuario_fk)->orderBy('dt_pagamento', 'desc');
        $dado = array();
        $datas = array();
        if($request->has('inicio'))
        {
            $vetor = explode('/', $request->get('inicio'));
            $inicio = $vetor[2]."-".$vetor[1]."-".$vetor[0];
            $vetor = explode('/', $request->get('fim'));
            $fim = $vetor[2]."-".$vetor[1]."-".$vetor[0];
            $atendimentos->whereBetween('dt_atendimento',array($inicio,$fim));
            $transferencia->whereBetween('dt_pagamento',array($inicio,$fim));
        }
        $transferencia = $transferencia->get();
        $atendimentos = $atendimentos->get();
        foreach($atendimentos as $linha)
        {
            $linha['tipo'] = 1;
            $linha['data'] = date('d/m/Y', strtotime($linha->dt_atendimento))." ".substr($linha->hr_inicio, 11);
            $linha['valor'] = $linha->vl_total * 0.4;
            $linha['motivo'] = "Atendimento#".$linha->cd_atendimento;
            $dado[] = $linha;
            $datas[] = strtotime($linha->dt_atendimento." ".substr($linha->hr_inicio, 11));
        }
        foreach($transferencia as $linha)
        {
            $linha['tipo'] = 2;
            $linha['data'] = date('d/m/Y', strtotime($linha->dt_pagamento))." ".$linha->hr_pagamento;
            $linha['valor'] = $linha->vl_comissao;
            $linha['motivo'] = "Fechamento#".$linha->cd_transferencia;
            $dado[] = $linha;
            $datas[] = strtotime($linha->dt_pagamento." ".$linha->hr_pagamento);

        }
        $parcial = $this->orderna($datas, $dado);
        $inicio =  ($request->has('page')) ? (intval($request->get('page'))*10)-10 : 0;
        $fim = $inicio+10;
        $dados = array();
        $tamanho = count($parcial);
        for($i = $inicio; $i < $fim; $i++)
        {
            try
            {
                $dados[] = $parcial[$i];
            }
            catch(\ErrorException $ex)
            {

            }
        }
        return view('painel-consultor.relatorio-credito-transferencias', compact('dados', 'tamanho', 'consultor'));
    }

    public function orderna($datas, $dados)
    {
        $aux1 = null;
        $aux2 = null;
        for($i = 0; $i < count($dados); $i++)
        {
            for($j = $i+1; $j < count($dados); $j++)
            {
                if($datas[$i] < $datas[$j])
                {
                    $aux1 = $datas[$j];
                    $aux2 = $dados[$j];
                    $datas[$j] = $datas[$i];
                    $dados[$j] = $dados[$i];
                    $datas[$i] = $aux1;
                    $dados[$i] = $aux2;
                }
            }
        }
        return $dados;
    }
}
