<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Consultor;
use Carbon\Carbon;
use App\Especialidade;
use App\EspecialidadeConsultor;
use App\User;
use Illuminate\Support\Facades\DB;

class DashBoardConsultorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(){

    }

    public function index(Request $request)
    {
        $id = Auth::user()->cd_usuario_fk;
        $dados = Consultor::leftJoin('tb_atendimentos', 'fk_atendimento_consultor', '=', 'cd_consultor')
        ->leftjoin('tb_visitantes', 'fk_atendimento_visitante', '=', 'cd_visitante')
        ->where('cd_consultor', '=', $id)
        ->where('vl_total', '>', 0)
        ->orderBy('dt_atendimento', 'desc')
        ->limit(5)
        ->get();
        $consultor = Consultor::find(Auth::user()->cd_usuario_fk);
        switch(strtotime($consultor->dt_login)){
            case strtotime("01/01/2000 00:00:00"):
                $consultor['st_status'] = 'ocupado';
            break;
            default:
                $consultor['st_status'] = 'online';
        }
        foreach($dados as $dado){
            $dado['tempo'] = gmdate('H:i:s', strtotime($dado->hr_termino) - strtotime($dado->hr_inicio));
            $dado['comissao'] = $dado->vl_total * 0.4;
        }
        return view('painel-consultor.dashboard', compact('dados', 'consultor'));
    }

    public function alteraStatus(Request $request){
        $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
        $status = $request->status;
        if($request->has('status')){
            if($status == "online"){
                $consultor->dt_login = Carbon::now();
            }
            else if($status == "ocupado"){
                $dt = '00:00:00 01/01/2000';
                $consultor->dt_login = date('Y-m-d H:i:s', strtotime($dt));
            }
            $consultor->save();
        }
        return $this->index($request);
    }

    public function alteraStatusAjax(Request $request){
        $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
        $status = $request->status;
        if($request->has('status')){
            if($status == "online"){
                $consultor->dt_login = Carbon::now();
            }
            else if($status == "ocupado"){
                $dt = '00:00:00 01/01/2000';
                $consultor->dt_login = date('Y-m-d H:i:s', strtotime($dt));
            }
            $consultor->save();
        }
        return json_encode(array('success'=>'Alterado'));
    }

    public function dataLogin(){
        $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
        $consultor->dt_login = Carbon::now();
        $consultor->save();
    }

    public function dataLogout(){
        if(Auth::user() != null){
            $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
            $consultor->dt_login = null;
            $consultor->save();
        }
        else{
            return redirect('/');
        }
    }

    public function alteraSenha(Request $request){
        $rules = [
            'senha_atual' => 'required',
            'nova_senha' => 'required|confirmed|min:6|max:30',
            'nova_senha_confirmation' => 'required'
        ];

        $messages = [
            'senha_atual.required' => 'O campo de senha atual é obrigatório.',
            'nova_senha.required' => 'O campo de nova senha é obrigatório.',
            'nova_senha.confirmed' => 'A confirmação da nova senha não está correta.',
            'nova_senha.min' => 'A nova senha deve ter no mínimo 6 caracteres.',
            'nova_senha.max' => 'A nova senha deve ter no máximo 30 caracteres.',
            'nova_senha_confirmation.required' => 'Confirme sua senha.'
        ];
        $this->validate($request, $rules, $messages);
        $user = new \App\Http\Controllers\UsuarioController(new User);
        if($user->alterarSenha(Auth::user()->cd_usuario, $request)){
            return back()->with('success', 'Senha alterada com sucesso!');
        }
        else{
            return back()->withErrors('Senha atual incorreta');
        }
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
        //
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
    public function edit()
    {
        $consultores = Consultor::find(Auth::user()->cd_usuario_fk);
        $consultores->dt_nascimento = date('d/m/Y', strtotime($consultores->dt_nascimento));
        $especialidades = Especialidade::all();
        $usuarios = User::where('cd_usuario', '=', Auth::user()->cd_usuario)->where('cd_role', 2)->get();
        $referencia = $especialidade = EspecialidadeConsultor::where('fk_especialidade_consultor','=', Auth::user()->cd_usuario_fk)->get();
        return view('painel-consultor.minha-conta.alterar-cadastro', compact('consultores', 'especialidades', 'usuarios', 'referencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function AlteraCadastro(Request $request, ImageRepository $repo)
    {
        $rules = [
            'nome' => 'required|min:10|max:60',
            'cpf' => 'required|cpf',
            'nascimento' => 'nullable|data',
            'sexo' => 'nullable',
            'email' => 'required|email',
            'celular' => 'nullable|min:10|max:11',
            'estado' => 'nullable',
            'cidade' => 'nullable|min:2|max:30',
            'dsc' => 'nullable',
            'especialidade' => 'nullable',
            'foto' => 'nullable|image|file'
        ];
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 10 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 60 caracteres.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.cpf' => 'Informe um cpf válido.',
            'nascimento.required' => 'O campo nascimento é obrigatório.',
            'nascimento.data' => 'Informe uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'celular.min' => 'O campo celular deve ter no mínimo 10 digitos',
            'celular.max' => 'O campo celular deve ter no máximo 11 digitos',
            'estado.digits' => 'O campo estado deve ter exatos 2 caracteres.',
            'cidade.min' => 'O campo cidade deve ter no mínimo 2 caracteres.',
            'cidade.max' => 'O campo cidade deve ter no máximo 30 caracteres.',
            'foto.image' => 'A foto deve ser uma imagem.',
            'foto.file' => 'A foto deve ser um arquivo de imagem.'
        ];

        // Retira máscara
        $request['celular'] = preg_replace('/[^0-9]/','', $request->get('celular'));
        if($request->get('foto') != null){
            $request->merge(['foto' => $request->foto]);
        }
        $this->validate($request, $rules, $messages);
        $consultores = \App\Consultor::All();
        $users = \App\User::All();
        foreach($consultores as $c){
            if($c->cd_cpf == $request->cpf){
                if(!($c->cd_consultor == Auth::user()->cd_usuario_fk)){
                    return back()->withErrors('CPF já cadastrado');
                }
            }
        }
        $request['cpf'] = preg_replace('/\D/', '', $request->get('cpf'));
        foreach($users as $u){
            if($u->email == $request->email){
                if(!($u->cd_usuario_fk == Auth::user()->cd_usuario_fk)){
                    return back()->withErrors('E-mail já cadastrado');
                }
            }
        }



        // Transforma para a data correta mysql
        if($request['nascimento'] != "")  {
            $request['nascimento'] = date('Y-m-d',strtotime(str_replace('/','-',$request->get('nascimento'))));
        }

        $consultor = \App\Consultor::find(Auth::user()->cd_usuario_fk);
        // Muda a foto
        if ($request->foto != "") {
            $userfoto = $repo->saveImage($request->foto);
            $repo->apagarImages(DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'especialistas'.DIRECTORY_SEPARATOR.$consultor->img_consultor);
        } else {
            $userfoto = $consultor->img_consultor;
        }
        try {
            DB::beginTransaction();
            $consultor->nm_consultor = $request->get('nome');
            $consultor->cd_cpf = $request->get('cpf');
            $consultor->dt_nascimento = $request->get('nascimento');
            $consultor->ic_sexo = $request->get('sexo')=="1" ? "F" : "M";
            $consultor->cd_celular = $request->get('celular');
            $consultor->sg_estado = $request->get('estado');
            $consultor->nm_cidade = $request->get('cidade');
            $consultor->ds_consultor = $request->get('dsc');
            $consultor->img_consultor = $userfoto;
            $consultor->save();

            // Altera a conta correspondente a este consultor
            $user = new \App\Http\Controllers\UsuarioController(new User);
            $user->update($request, Auth::user()->cd_usuario);

            // Exclui todas as especialidades deste consultor
            DB::table('tb_especialidades_consultores')->where('fk_especialidade_consultor', $consultor->cd_consultor)->delete();

            // Insere as novas especialidades
            $esp = $request->input('especialidade', []);
            foreach($esp as $r) {
                $especialidade = new EspecialidadeConsultor([
                    'fk_especialidade_consultor' => $consultor->cd_consultor,
                    'fk_consultor_especialidade' => $r
                ]);
                $especialidade->save();
            }
            DB::commit();
        } catch (Exception $e) {
            return redirect('painel-consultor.minha-conta.alterar-cadastro')->withErrors('Ocorreu um erro, não foi possivel atualizar suas informações');
        }

        return back()->with('success', 'Dados alterados com sucesso');
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
