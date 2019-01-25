<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SiteVisitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('site.visitor.alter-register', compact('visitante'));
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
            'email' => 'required|email',
        ];
        $mensagens = [
            'nm_visitante.required' => 'Nome obrigatorio',
            'nm_visitante.min' => 'Nome de tamanho insuficiente',
            'nm_visitante.max' => 'Nome de tamanho superior ao permitido',
            'email.required' => 'Informe um e-mail.',
            'email.email' => 'Informe um e-mail válido.'
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
        $visitante->save();
        $user = new \App\Http\Controllers\UsuarioController(new User);
        $user->update($request, $request->get('id_user'));
        return back()->with('success', 'Dados alterados com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
