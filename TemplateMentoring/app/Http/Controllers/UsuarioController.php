<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    private $user;
    function __construct(User $user) {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, int $id, int $role)
    {
        $this->validate($request, $this->user->Regras('insert'), $this->user->mensagens);
        $user = new \App\User;
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('senha'));
        $user->cd_usuario_fk = $id;
        $user->cd_role = $role;
        if($request->has('status')){
            $user->status = $request->get('status');
            $user->save();
        }
        else{
            $user->status = 1;
            $user->save();
            $request->merge(['nm_login' => $request->email]);
            $request->merge(['cd_senha' => $request->senha]);
            $this->logar($request);
        }
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
        //
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
        $this->validate($request, $this->user->Regras('update'), $this->user->mensagens);
        $user = \App\User::find($id);
        $user->email = $request->get('email');
        $user->status = (Auth::user()->cd_role == 2)? 1 : $request->get('status');
        $user->save();
    }

    public function mudaSenha($id, $senha)
    {
        $user = \App\User::find($id);
        $user->password = Hash::make($senha);
        $user->save();
    }
    public function alterarSenha($id, Request $request)
    {
        $user = \App\User::find($id);
        $credenciais = Array('email' => Auth::user()->email, 'password' => $request->get('senha_atual'));
        if(Auth::attempt($credenciais, false)){
            $user->password = Hash::make($request->get('nova_senha'));
            $user->save();
            return true;
        }
        return false;
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

    public function logarAdmin(Request $request)
    {
        $this->validate($request, $this->user->Regras('login'), $this->user->mensagens);
        $credenciais = Array('email' => $request->get('email'), 'password' => $request->get('password'));
        if(Auth::attempt($credenciais, false))
        {
            if(Auth::user()->cd_role == 1)
            {
                return redirect('/admin');
            }
            else
            {
                Auth::logout();
                return back()->withErrors(['Você não tem permissão para acessar esta pagina']);
            }
        }
        else {
            return back()->with('failure', 'Senha incorreta');
        }
    }

    public function logarConsultor(Request $request)
    {
        $this->validate($request, $this->user->Regras('login'), $this->user->mensagens);
        $credenciais = Array('email' => $request->get('email'), 'password' => $request->get('senha'));
        if(Auth::attempt($credenciais, false))
        {
            if(Auth::user()->cd_role == 2 && Auth::user()->status == 1)
            {
                $dashboard = new DashBoardConsultorController();

                $dashboard->dataLogin();

                return redirect('/painel-consultor');
            }
            else
            {
                Auth::logout();
                return back()->withErrors(['Você não tem permissão para acessar esta pagina']);
            }
        }
        else {
            return back()->withErrors(['Senha incorreta']);
        }
    }

    public function logar(Request $request)
    {
        $this->validate($request, $this->user->Regras('login'), $this->user->mensagens);
        $credenciais = Array('email' => $request->get('nm_login'), 'password' => $request->get('cd_senha'));
        if(Auth::attempt($credenciais, false))
        {
            if(Auth::user()->cd_role == 3 && Auth::user()->status == 1)
            {
                if($request->has('telaComprar'))
                {
                    return redirect('/comprar-minutos');
                }
                else
                {
                    return back();
                }
            }
            else {
                Auth::logout();
                return back()->with('errorLogin', 'Email ou senha informados estão incorretos');
            }
        }
        else
        {
            return back()->with('errorLogin', 'Email ou senha informados estão incorretos');
        }
    }
    public function logout(Request $request)
    {
        if(Auth::user()!= null){
            if(Auth::user()->cd_role == 2){
                $dashboard = new DashBoardConsultorController();

                $dashboard->dataLogout();
            }
            Auth::logout();
        }
        return redirect('/');
    }
}
