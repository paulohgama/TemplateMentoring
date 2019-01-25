<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Visitante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $termo = $request->get('termo');
        $start = $request->get('start');
        $result = $this->dadosAjax($termo, $start);
        $filtro = [
            'termo' => $termo,
        ];
        return View('admin.visitante.index')->with([
            'lista' => $result,
            'filtro' => $filtro,
        ]);
    }

    public function show(int $id){
        $visitante = DB::table('tb_visitantes')
        ->join('tb_usuarios', function ($join) use($id) {
            $join->on('cd_usuario_fk', '=', 'cd_visitante')->where('cd_role', '=', 3)->where('cd_visitante', '=', $id);
        })
        ->get();
        return view('admin.visitante.show', compact('visitante'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.visitante.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = [
            'nm_visitante' => 'bail|sometimes|required|min:3|max:100',
            'email' => 'bail|sometimes|required|min:5|max:100|email|unique:tb_usuarios,email',
            'senha' => 'bail|sometimes|required|min:5|max:100'
        ];
        $mensagens = [
            'nm_visitante.required' => 'Nome obrigatorio',
            'nm_visitante.min' => 'Nome de tamanho insuficiente',
            'nm_visitante.max' => 'Nome de tamanho superior ao permitido',
            'email.required' => 'E-mail obrigatorio',
            'email.min' => 'E-mail de tamanho insuficiente',
            'email.max' => 'E-mail de tamanho superior ao permitido',
            'email.email' => 'E-mail invalido',
            'email.unique' => 'E-mail já cadastrado',
            'senha.min' => 'Senha tamanho insuficiente',
            'senha.max' => 'Senha de tamanho superior ao permitido',
            'senha.required' => 'Senha obrigatoria'
        ];
        $this->validate($request, $regras, $mensagens);
        $visitante = new \App\Visitante;
        $user = new \App\Http\Controllers\UsuarioController(new User);
        $visitante->nm_visitante = $request->get('nm_visitante');
        $visitante->qt_segundos = 0;
        if ($visitante->save()) {
            $user->store($request, $visitante->cd_visitante, 3);
            if(Auth::user()->cd_role == 1){
                return back()->with('success', 'Visitante cadastrado com sucesso');
            }
            else{
                if($request->has('telaComprar'))
                {
                    return redirect('/comprar-minutos');
                }
                return redirect('/');
            }

        }
        return back()->withErrors('Erro', 'Deu erro');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitante = DB::table('tb_visitantes')
        ->join('tb_usuarios', function ($join) use($id) {
            $join->on('cd_usuario_fk', '=', 'cd_visitante')->where('cd_role', '=', 3)->where('cd_visitante', '=', $id);
        })
        ->get();
        return view('admin.visitante.edit', compact('visitante'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $regras = [
            'nm_visitante' => 'bail|sometimes|required|min:3|max:100',
            'qt_minutos' => 'bail|sometimes|required|numeric',
            'qt_segundos' => 'bail|sometimes|required|numeric'
        ];
        $mensagens = [
            'nm_visitante.required' => 'Nome obrigatorio',
            'nm_visitante.min' => 'Nome de tamanho insuficiente',
            'nm_visitante.max' => 'Nome de tamanho superior ao permitido',
            'qt_minutos.required' => 'Quantidade de créditos obrigatoria',
            'qt_minutos.number' => 'Quantidade de créditos deve ser um número',
            'qt_segundos.required' => 'Quantidade de créditos obrigatoria',
            'qt_segundos.number' => 'Quantidade de créditos deve ser um número'
        ];
        $this->validate($request, $regras, $mensagens);
        $visitante = \App\Visitante::find($id);
        $users = \App\User::All();
        foreach($users as $u){
            if($u->email == $request->email){
                if(!($u->cd_usuario_fk == $id)){
                    return back()->withErrors('E-mail já cadastrado');
                }
            }
        }
        $visitante->nm_visitante = $request->get('nm_visitante');
        $visitante->qt_segundos = $request->get('qt_minutos')*60+$request->get('qt_segundos');
        $visitante->save();
        $user = new \App\Http\Controllers\UsuarioController(new User);
        $user->update($request, $request->get('id_user'));
        return redirect('admin/visitante/')->with('success', 'Visitante editado com sucesso');
        return back()->withErrors('Erro', 'Deu erro');
    }
    public function dadosAjax($search = '', $start = 0)
    {

        $columns = array(
            0 => 'cd_visitante',
            1 => 'nm_visitante'
        );

        if($search == '') {
            $visitantes = Visitante::offset($start)
                ->limit(10)
                ->orderBy('cd_visitante', 'desc')
                ->paginate(10);
        } else {
            $visitantes = Visitante::where('cd_visitante', 'like', "%{$search}%")
                ->orWhere('nm_visitante', 'like', "%{$search}%")
                ->offset($start)
                ->orderBy('cd_visitante', 'desc')
                ->paginate(10)->appends(['termo' => request('termo')]);
        }
        return $visitantes;
    }
}
