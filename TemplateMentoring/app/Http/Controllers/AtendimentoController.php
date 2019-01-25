<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Atendimentos;
use App\Valor;
use App\Visitante;
use App\Consultor;
use App\Mensagem;
use App\User;
use App\Mail\EnviarEmail;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $termo = ($request->get('termo') != null)? $request->get('termo') : '';
        $visitante = ($request->get('visitante') != null)? $request->get('visitante') : '';
        if(Auth::user()->cd_role == 1){
            $consultor = ($request->get('consultor') != null)? $request->get('consultor') : '';
        }
        else{
            $consultor = Auth::user()->cd_usuario_fk;
        }
        $split1 = explode('/', $request->get('dt_inicio'));
        $split2 = explode('/', $request->get('dt_final'));
        if ($request->get('dt_inicio') != null)
            $dt_inicio = $split1[2].'-'.$split1[1].'-'.$split1[0];
        else
            $dt_inicio = '2000-12-12';
        if ($request->get('dt_final') != null)
            $dt_final = $split2[2].'-'.$split2[1].'-'.$split2[0];
        else
            $dt_final = '2050-12-12';
        $result = $this->dadosAjax($termo, $consultor, $dt_inicio, $dt_final, $visitante);
        $filtro = [
            'termo' => $termo,
            'consultor' => $consultor,
            'visitante' => $visitante,
            'dt_inicial' => $dt_inicio,
            'dt_final' => $dt_final,
        ];
        if(Auth::user()->cd_role == 1){
            return View('admin.atendimento.index')->with([
                'lista' => $result,
                'filtro' => $filtro,
            ]);
        }
        if(Auth::user()->cd_role == 2){
            return View('painel-consultor.atendimento.relatorio')->with([
                'lista' => $result,
                'filtro' => $filtro,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $atendimento = new \App\Atendimentos;
        $atendimento->fk_atendimento_consultor = $id;
        $atendimento->fk_atendimento_visitante = Auth::user()->cd_usuario_fk;
        $atendimento->dt_atendimento = date('Y-m-d');
        $atendimento->hr_inicio = date('Y-m-d H:i:s');
        $atendimento->status_transacao = 0;
        $atendimento->status_atendimento = 0;
        $atendimento->save();
        $idA = $atendimento->cd_atendimento;
        $atendimento = DB::table('tb_atendimentos')
        ->join('tb_consultores', function ($join) use($id) {
            $join->on('fk_atendimento_consultor', '=', 'cd_consultor')->where('fk_atendimento_consultor', '=', $id);
        })
        ->join('tb_visitantes', 'fk_atendimento_visitante', '=', 'cd_visitante')
        ->where('cd_atendimento', $idA)
        ->get();
        return View('site/chat/visitor', compact('atendimento'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $atendimento = DB::table('tb_atendimentos')
        ->join('tb_consultores', function ($join) use($id) {
            $join->on('fk_atendimento_consultor', '=', 'cd_consultor')->where('cd_atendimento', '=', $id);
        })
        ->join('tb_visitantes', 'fk_atendimento_visitante', '=', 'cd_visitante')
        ->get();
        $mensagens = DB::table('tb_mensagens')
        ->join('tb_atendimentos', 'fk_mensagem_atendimento', '=', 'cd_atendimento')->where('cd_atendimento', '=', $id)->get();
        if(Auth::user()->cd_role == 1){
            return view('admin.atendimento.show', compact('atendimento', 'mensagens'));
        }
        elseif(Auth::user()->cd_role == 2){
            return view('painel-consultor.atendimento.visualizar', compact('atendimento', 'mensagens'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateFinal(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $atendimento = \App\Atendimentos::find($request->get('id'));
        if($atendimento->hr_cobranca != null){
            if($atendimento->vl_total == null){
                $cobranca = strtotime($atendimento->hr_cobranca);
                $cobranca+= ($request->time);
                $atendimento->hr_termino = date('Y-m-d H:i:s', $cobranca);
                $valores = DB::table('tb_valores')->orderBy('cd_valor', 'desc')->first();
                $hora = strtotime($atendimento->hr_termino) - strtotime($atendimento->hr_cobranca);
                if($hora > 3600)
                {
                    $H = date('H', $hora);
                    $M = date('i', $hora);
                    $S = date('s', $hora);
                }
                else
                {
                    $H = 0;
                    $M = date('i', $hora);
                    $S = date('s', $hora);
                }
                $atendimento->vl_total = ($H*60 + $M + $S/60) * $valores->valor;
                $atendimento->status_atendimento = $request->get('status');
                $visitante = \App\Visitante::find($atendimento->fk_atendimento_visitante);
                $visitante->qt_segundos = $request->restante;
                $visitante->save();
                $consultor = \App\Consultor::find($atendimento->fk_atendimento_consultor);
                $consultor->qt_creditos = $consultor->qt_creditos + ($atendimento->vl_total * 0.4);
                $consultor->dt_login = Carbon::now();
                $consultor->save();
                $data['nome'] = $visitante->nm_visitante;
                $data['dia'] = date('d/m/Y', strtotime($atendimento->dt_atendimento));
                $data['horario'] = str_replace(':', 'h', (string)date('H:i', strtotime($atendimento->hr_inicio)));
                $data['consultor'] = $consultor->nm_consultor;
                $data['msg'] = \App\Mensagem::where('fk_mensagem_atendimento', '=', $atendimento->cd_atendimento)->get();
                $data['view'] = 'emails.atendimento';
                $data['subject'] = 'Atendimento finalizado';
                $user = \App\User::where('cd_usuario_fk', '=', $atendimento->fk_atendimento_visitante)->where('cd_role', '=', '3')->get();
                \Mail::to($user[0]->email)->send(new EnviarEmail($data));
            }
        }
        else{
            $atendimento->vl_total = 0;
            $atendimento->status_atendimento = 2;
        }
        $atendimento->update();
        return json_encode(array('status' => $atendimento->hr_inicio));
    }
    //consultor atende a chamada
    public function updateConsultor($id)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $atendimento = \App\Atendimentos::find($id);
        $atendimento->hr_cobranca = date('Y-m-d H:i:s');
        $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
        $consultor->dt_login = date('Y-m-d H:i:s', strtotime('00:00:00 01/01/2000'));
        $consultor->save();
        $atendimento->update();
        $atendimento = DB::table('tb_atendimentos')
        ->join('tb_consultores', function ($join) use($id) {
            $join->on('fk_atendimento_consultor', '=', 'cd_consultor')->where('cd_atendimento', '=', $id);
        })
        ->join('tb_visitantes', 'fk_atendimento_visitante', '=', 'cd_visitante')
        ->get();
        $valor = DB::table('tb_valores')->orderBy('cd_valor', 'desc')->first();
        return View('site.chat.consultant', compact('atendimento', 'valor'));
    }
    public function dadosAjax($search, $consultor, $dt_inicio, $dt_final, $visitante)
    {
        $atendimentos = DB::table('tb_atendimentos')->leftjoin('tb_consultores', function ($join) use($search, $dt_inicio, $dt_final) {
            $join->on('fk_atendimento_consultor', '=', 'cd_consultor');
        })->leftjoin('tb_visitantes', function ($join) use($search){
            $join->on('fk_atendimento_visitante', '=', 'cd_visitante');
        })
        ->Where(function ($query) use ($search) {
            $query->Where('nm_visitante', 'like', '%'.$search.'%');
            if(Auth::user()->cd_role != 2){
                $query->orWhere('nm_consultor', 'like', '%'.$search.'%');
            }
        })->where('dt_atendimento', '>=', $dt_inicio)->where('dt_atendimento', '<=', $dt_final);
        if($consultor != ''){
            $atendimentos->where('cd_consultor', '=', $consultor);
        }
        if($visitante != ''){
            $atendimentos->where('fk_atendimento_visitante', '=', $visitante);
        }
        $split1 = explode('-', $dt_inicio);
        $dt_inicio = $split1[2].'/'.$split1[1].'/'.$split1[0];
        $split2 = explode('-', $dt_final);
        $dt_final = $split2[2].'/'.$split2[1].'/'.$split2[0];

        $atendimentos = $atendimentos->orderBy('cd_atendimento', 'desc')->paginate(10)->appends('termo', $search)->appends('visitante', $visitante)->appends('consultor', $consultor)->appends('dt_inicio', $dt_inicio)->appends('dt_final', $dt_final);

        return $atendimentos;
    }
}
