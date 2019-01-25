<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transferencias;
use App\Atendimentos;
use App\Consultor;
use App\Valor;
use App\User;
use App\Mail\EnviarEmail;
use Illuminate\Support\Facades\Auth;

class TransferenciaController extends Controller
{

    public function Pendentes(Request $request) {
        $consultores = Consultor::where('qt_creditos',  ">",  0);
        $transferencias = array();
        $t = Atendimentos::join('tb_consultores', 'fk_atendimento_consultor', '=', 'cd_consultor')->where("status_transacao" , 0)->orderBy('fk_atendimento_consultor', 'asc')->orderBy('dt_atendimento', 'asc');
        $termo = $request->get('termo');
        $transf = $t->where('nm_consultor', 'like', "%{$termo}%")->get();
        foreach($consultores->offset(($request->get('pagina')*10)-10)->limit($request->get('pagina')*10)->get() as $linhaConsultor)
        {
            $consultor = array();
            foreach($transf as $linhaTransferencia){
                if($linhaTransferencia->fk_atendimento_consultor == $linhaConsultor->cd_consultor) {
                    $consultor[] = $linhaTransferencia;
                }
            }
            if($consultor != null){
                $transferencias[] = $consultor;
            }
        }
        // dd($transferencias);
        $transfDataTratada = $this->TratarData($transferencias);
        $valorTotal = $this->ValorTotal($transferencias);
        $dados = array();
        for($i = 0; $i < count($transferencias); $i++)
        {
            $dadosParciais = array();
            $dadosParciais['nome'] = $transferencias[$i][0]->nm_consultor;
            $dadosParciais['datainicio'] = substr($transfDataTratada[$i], 0, 10);
            $dadosParciais['datafim'] = substr($transfDataTratada[$i], 11);
            $dadosParciais['valortotal'] = $valorTotal[$i];
            $dadosParciais['comissao'] = $valorTotal[$i] * 0.4;
            $dadosParciais['atendimentos'] = "<a href='".route('admin.atendimento.index')."?dt_inicio=".substr($transfDataTratada[$i], 0, 10)."&dt_final=".substr($transfDataTratada[$i], 11)."&consultor=".$transferencias[$i][0]->cd_consultor."'>"
                                                        .count($transferencias[$i]). " Atendimento(s)
                                                    </a>";
            $dadosParciais['botao'] =   "<a href='#' role='button' class='btn btn-success' data-modal='user' data-consultor='".$transferencias[$i][0]->cd_consultor."'>
                                            <span class='glyphicon glyphicon-download-alt'></span></p>
                                        </a>";
            $dados[] = $dadosParciais;
        }
        $dados[] = count($transferencias);
        return json_encode($dados);
    }

    public function Realizados(Request $request)
    {
        $transferencias = Transferencias::join('tb_consultores','fk_transferencia_consultor', '=', 'cd_consultor');
        $termo = $request->get('termo');
        $transferencias = $transferencias->where('nm_consultor', 'like', "%{$termo}%");
        $dados = array();
        foreach($transferencias->offset(($request->get('pagina')*10)-10)->limit($request->get('pagina')*10)->get() as $trasferencia)
        {
            $subDados = array();
            $subDados['id'] = $trasferencia->cd_transferencia;
            $subDados['nome'] = $trasferencia->nm_consultor;
            $subDados['periodo'] = $trasferencia->dt_periodo_pago;
            $subDados['pagamento'] =  date('d/m/Y', strtotime($trasferencia->dt_pagamento)) ." ". $trasferencia->hr_pagamento;
            $subDados['total'] = $trasferencia->vl_total;
            $subDados['comissao'] = $trasferencia->vl_comissao;
            $subDados['atendimentos'] =  "<a href='".route('admin.atendimento.index')."?dt_inicio=".$this->trataData($trasferencia->dt_periodo_pago, true)."&dt_final=".$this->trataData($trasferencia->dt_periodo_pago, false)."&consultor=".$trasferencia->cd_consultor."'>"
                                                        .$trasferencia->qnt_atendimento. " Atendimento(s)
                                                    </a>";
            $dados[] = $subDados;
        }
        $dados[] = Transferencias::all()->count();
        return json_encode($dados);
    }

    public function trataData($data, $inicioFim)
    {
        $retorno = '';
        if($inicioFim)
        {
            if(strlen($data) == 10)
            {
                $retorno = $data;
            }
            else
            {
                $retorno = substr($data, 0, 10);
            }
        }
        else
        {
            if(strlen($data) == 10)
            {
                $retorno = $data;
            }
            else
            {
                $retorno = substr($data, 14);
            }
        }
        return $retorno;
    }

    public function TratarData($transferencias)
    {
        $transfTratada = array();
        for($i = 0; $i < count($transferencias); $i++)
        {
            $data = date_create($transferencias[$i][0]->dt_atendimento);
            $temp = date_format($data, 'd/m/Y'). "|";
            if(count($transferencias[$i]) > 1)
            {
               $data = date_create($transferencias[$i][count($transferencias[$i])-1]->dt_atendimento);
               $temp .= date_format($data, 'd/m/Y');
            }
            else
            {
                $temp .= date_format($data, 'd/m/Y');
            }
            $transfTratada[] = $temp;
        }
        return $transfTratada;
    }

    public function ValorTotal($transferencias)
    {
        $total = array();
        for($i = 0; $i < count($transferencias); $i++)
        {
            $temp = 0;
            for($j = 0; $j < count($transferencias[$i]); $j++)
            {
                $temp += $transferencias[$i][$j]->vl_total;
            }
            $total[] = $temp;
        }
        return $total;
    }

    public function PendenteConsultor(Request $request)
    {
        $tranf = Atendimentos::join('tb_consultores', 'fk_atendimento_consultor', '=', 'cd_consultor')->where('fk_atendimento_consultor', $request->consultor)->where("status_transacao" , 0)->orderBy('dt_atendimento', 'asc');
        if($tranf->count() > 0)
        {
            $transacao = $tranf->get();
            $retorno = array();
            $retorno['nome'] = $transacao[0]->nm_consultor;
            $retorno['id'] = $transacao[0]->cd_consultor;
            $array = array();
            foreach($transacao as $linha)
            {
                $sarray = array();
                $sarray['valor'] = $linha->vl_total;
                $sarray['data'] = date('m-d-Y', strtotime($linha->dt_atendimento));
                $sarray['dataC'] = date('d/m/Y', strtotime($linha->dt_atendimento));
                $array[] = $sarray;
            }
            $retorno['valoresDatas'] = $array;
            return json_encode($retorno);
        }
    }
    public function DarBaixa(Request $request)
    {
        $datainicio = $request->get('datainicio');
        $datafim = $request->get('datafim');
        $id = $request->get('cd_consultor');
        $data[] = explode("/", $datainicio);
        $datainicio = $data[0][2].'-'.$data[0][1].'-'.$data[0][0];
        $data[] = explode("/", $datafim);
        $datafim = $data[1][2].'-'.$data[1][1].'-'.$data[1][0];
        $atendimentos = Atendimentos::where('dt_atendimento', ">=", $datainicio)->where('dt_atendimento', "<=", $datafim)->where('fk_atendimento_consultor', $id)->where('status_transacao', 0)->get();
        $atendimentosUpdate = Atendimentos::where('dt_atendimento', ">=", $datainicio)->where('dt_atendimento', "<=", $datafim)->where('fk_atendimento_consultor', $id)->update(['status_transacao' => 1]);
        $consultor = Consultor::find($atendimentos[0]->fk_atendimento_consultor);
        $totalDebitado = 0;
        foreach ($atendimentos as $linha) {
            $totalDebitado += $linha->vl_total;
        }
        date_default_timezone_set('America/Sao_Paulo');
        $periodo = ($request->get('datainicio') != $request->get('datafim')) ? $request->get('datainicio'). " à ". $request->get('datafim') : $request->get('datainicio');
        $consultor->qt_creditos = $consultor->qt_creditos - ($totalDebitado * 0.4);
        $consultor->update();
        $transferencias = new Transferencias([
            'dt_periodo_pago' => $periodo,
            'vl_total' => $totalDebitado,
            'vl_comissao' => $totalDebitado * 0.4,
            'qnt_atendimento' => $atendimentos->count(),
            'fk_transferencia_consultor' => intval($id),
            'dt_pagamento' => date('Y-m-d'),
            'hr_pagamento' => date('H:i:s')
        ]);
        $user = User::where('cd_usuario_fk', $id)->first();
        $transferencias->save();
        $data['inicio'] =  "Prezado consultor ".$consultor->nm_consultor.",";
        $data['conteudo'] =  "O Tarot Nova Era acaba de realizar uma transferência".
                            " referente à comissão dos seus atendimentos realizados ".
                            "em nosso site de ".$periodo." no valor total de R$ ".\number_format($totalDebitado*0.4, 2, ',', '.').".";
        $data['final'] =  "Por favor, aguarde até 2 dias úteis para a confirmação do recebimento do pagamento.";
        $data['footer'] =  "Essa transação foi registada em sua área do consultor.";
        $data['view'] = 'emails.baixa';
        $data['subject'] = 'Transferência realizada';

        \Mail::to($user->email)->cc(Auth::user()->email)->send(new EnviarEmail($data));
        return json_encode(array("success" => 'Salvo'));
    }
}
