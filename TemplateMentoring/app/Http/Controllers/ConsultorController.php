<?php

namespace App\Http\Controllers;

use App\Consultor;
use App\Especialidade;
use App\EspecialidadeConsultor;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarEmail;
use App\Visitante;
use Illuminate\Support\Facades\Auth;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConsultorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultores = new Consultor;
        $consultores = $consultores->join('tb_usuarios', 'cd_usuario_fk', '=', 'cd_consultor')
        ->where('cd_role','=',2);
        if(request('termo') != '') {
            $termo = request('termo');

            if(request('termo')=="Ativado" || request('termo') == "Desativado") {
                $termo = $termo=="Ativado" ? "1" : ($termo=="Desativado" ? "0" : request('termo'));
                $consultores = $consultores->select('cd_consultor', 'nm_consultor', 'status', 'qt_creditos')
                ->Where('status', $termo)
                ->orderBy('cd_consultor', 'DESC')
                ->paginate(10)
                ->appends('termo',request('termo'));
            } else {
                $consultores = $consultores->select('cd_consultor', 'nm_consultor', 'status', 'qt_creditos')
                ->Where(function ($query) use ($termo) {
                    $query->Where('nm_consultor', 'LIKE', '%'.$termo.'%')
                    ->orWhere('cd_consultor', $termo);
                })
                ->orderBy('cd_consultor', 'DESC')
                ->paginate(10)
                ->appends('termo',$termo);
            }
        } else if(!request('status')) {
            $consultores = $consultores->orderBy('cd_consultor', 'DESC')->paginate(10);
        }

        return View('admin.consultor.index')->with([
            'lista' => $consultores
        ]);
    }

    public function indexSite(Request $request)
    {
        $search = ($request->get('termo') != null)? $request->get('termo') : '';
        $consultores = Consultor::where('dt_login', '!=', null)->where('nm_consultor', 'like', '%'.$search.'%')->join('tb_usuarios', 'cd_usuario_fk', '=', 'cd_consultor')->where('status', '=', '1')->where('cd_role', '=', '2')->orderBy('dt_login', 'desc')->paginate(6)->appends('termo', $search);

        $especialidades = Especialidade::join('tb_especialidades_consultores', 'fk_consultor_especialidade', '=', 'cd_especialidade')->get();
        foreach($consultores as $linhaConsultor)
        {
            $esp = array();
            foreach($especialidades as $linhaE){
                if($linhaE->fk_especialidade_consultor == $linhaConsultor->cd_consultor) {
                    $esp[] = $linhaE->nm_especialidade;
                }
            }
            $linhaConsultor['especialidades'] = $esp;
            $linhaConsultor['ds_consultor'] = html_entity_decode($linhaConsultor['ds_consultor']);
            switch($linhaConsultor['dt_login']) {
                case '2000-01-01 00:00:00':
                    $linhaConsultor['status'] = 'offline';
                break;
                case null:
                    $linhaConsultor['status'] = 'offline';
                break;
                default:
                    $linhaConsultor['status'] = 'online';
                break;
            }
            $linhaConsultor['ds_consultor'] = str_replace('<p>','',str_replace('</p>','',str_replace('<em>','',str_replace('</em>','',str_replace('<strong>','',str_replace('</strong>','',str_replace('<u>','',str_replace('</u>','',$linhaConsultor['ds_consultor']))))))));
        }
        return view('site/consultants/index', compact('consultores'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $especialidades = Especialidade::all();
        return view('admin/consultor/create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ImageRepository $repo)
    {
        $rules = [
            'nome' => 'required|min:10|max:60',
            'cd_cpf' => 'required|cpf|unique:tb_consultores',
            'nascimento' => 'nullable|data',
            'sexo' => 'nullable',
            'email' => 'required|email|unique:tb_usuarios',
            'senha' => 'required|confirmed|min:8|max:30',
            'senha_confirmation' => 'required|min:8|max:30',
            'celular' => 'nullable|min:10|max:11',
            'estado' => 'nullable',
            'cidade' => 'nullable|min:2|max:30',
            'observacao' => 'nullable|max:60',
            'especialidade' => 'nullable',
            'status' => 'required',
            'foto' => 'required|image|file'
        ];

        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 10 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 60 caracteres.',
            'cd_cpf.required' => 'O campo cpf é obrigatório.',
            'cd_cpf.cpf' => 'Informe um cpf válido.',
            'cd_cpf.unique' => 'Este CPF já está em uso.',
            'nascimento.required' => 'O campo nascimento é obrigatório.',
            'nascimento.data' => 'Informe uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'email.unique' => 'Este e-mail já está em uso',
            'senha.required' => 'O campo senha é obrigatório',
            'senha.confirmed' => 'A confirmação da senha não está correta.',
            'senha.min' => 'O campo senha deve ter no mínimo 8 caracteres.',
            'senha.max' => 'O campo senha deve ter no máximo 30 caracteres.',
            'senha_confirmation.required' => 'Digite a senha novamente.',
            'senha_confirmation.min' => 'O campo confirmação deve ter no mínimo 8 caracteres.',
            'senha_confirmation.max' => 'O campo confirmação deve ter no máximo 30 caracteres.',
            'celular.required' => 'O campo celular é obrigatório.',
            'celular.min' => 'O campo celular deve ter no mínimo 10 digitos',
            'celular.max' => 'O campo celular deve ter no máximo 11 digitos',
            'estado.required' => 'O campo estado é obrigatório.',
            'estado.digits' => 'O campo estado deve ter exatos 2 caracteres.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'cidade.min' => 'O campo cidade deve ter no mínimo 2 caracteres.',
            'cidade.max' => 'O campo cidade deve ter no máximo 30 caracteres.',
            'observacao.max' => 'O campo observação deve ter no máximo 60 caracteres.',
            'especialidade.required' => 'O campo especialidade é obrigatório.',
            'status.required' => 'O campo status é obrigatório.',
            'foto.required' => 'O campo foto é obrigatório.',
            'foto.image' => 'Imagem inválida.',
            'foto.file' => 'Imagem inválida.'
        ];
        $request['cd_cpf'] = preg_replace('/\D/', '', $request->get('cd_cpf'));
        $request['celular'] = preg_replace('/[^0-9]/','', $request->get('celular'));

        $this->validate($request, $rules, $messages);

        // Transforma para a data correta mysql
        if($request['nascimento'] != "")  {
            $request['nascimento'] = date('Y-m-d',strtotime(str_replace('/','-',$request->get('nascimento'))));
        }

        // Salva imagem
        $nameFile = $repo->saveImage($request->foto);

        $valor = ($request->get('status') == "1") ? true : false;

        try {
            DB::beginTransaction();
            $consultor = new Consultor([
                'nm_consultor' => $request->get('nome'),
                'cd_cpf' => $request->get('cd_cpf'),
                'dt_nascimento' => $request->get('nascimento'),
                'ic_sexo' => $request->get('sexo')=="1" ? "F" : "M",
                'cd_celular' => $request->get('celular'),
                'dt_login' => null,
                'sg_estado' => $request->get('estado'),
                'nm_cidade' => $request->get('cidade'),
                'ds_observacao' => $request->get('observacoes'),
                'img_consultor' => $nameFile,
                'qt_creditos' => 0
            ]);
            $consultor->save();

            $user = new User([
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('senha')),
                'cd_role' => 2,
                'status' => $valor,
                'cd_usuario_fk' => $consultor->cd_consultor
            ]);
            $user->save();

            // Salva as especialidades
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
            Storage::delete('public/'.$consultor->img_consultor);
            return redirect('admin/consultor/cadastrar')->with('error', 'Ocorreu um erro, Consultor não inserido');
        }

       $data['nome'] = $consultor->nm_consultor;
       $data['login'] = $user->email;
       $data['senha'] = $request->get('senha');
       $data['view'] = 'emails.registrado';
       $data['subject'] = 'Seja bem-vindo para o Tarot Nova Era!';

       \Mail::to($user->email)->send(new EnviarEmail($data));

        if (Mail::failures()) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar o e-mail.');
        }

        return redirect('admin/consultor/cadastrar')->with('success', 'Consultor Inserido');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultores = Consultor::find($id);

        $ocupado = "false";
        switch(strtotime($consultores->dt_login)){
            case strtotime("01/01/2000 00:00:00"):
                $ocupado = 'true';
            break;
            case null:
                $ocupado = 'true';
            break;
        }
        $usuarios = User::where('cd_usuario_fk',$consultores->cd_consultor)->where('cd_role', 2)->get();

        $especialidades = DB::table('tb_especialidades_consultores')
            ->join('tb_especialidades', 'tb_especialidades_consultores.fk_consultor_especialidade', '=', 'tb_especialidades.cd_especialidade')
            ->join('tb_consultores', 'tb_especialidades_consultores.fk_especialidade_consultor', '=', 'tb_consultores.cd_consultor')
            ->select('tb_especialidades.nm_especialidade')
            ->where('tb_consultores.cd_consultor','=', $id)
            ->get();
        if(Auth::user() == null)
        {
            $depoimentos = DB::table('tb_depoimentos')
            ->join('tb_visitantes', 'cd_visitante', '=', 'fk_depoimento_visitante')
            ->where('fk_depoimento_consultor', '=', $id)
            ->orderBy('dt_depoimento', 'desc')
            ->paginate(3);
            $visitante = array();
            $visitante['qt_segundos'] = 0;
            return view('site/consultants/show', compact('consultores', 'depoimentos', 'especialidades', 'visitante', 'ocupado'));
        }
        elseif(Auth::user()->cd_role == 1){
            return view('admin/consultor/show', compact('consultores', 'usuarios', 'especialidades'));
        }
        elseif(Auth::user()->cd_role == 3)
        {
            $visitante = Visitante::find(Auth::user()->cd_usuario_fk);
            $depoimentos = DB::table('tb_depoimentos')
            ->join('tb_visitantes', 'cd_visitante', '=', 'fk_depoimento_visitante')
            ->where('fk_depoimento_consultor', '=', $id)
            ->orderBy('dt_depoimento', 'desc')
            ->paginate(3);
            return view('site/consultants/show', compact('consultores', 'depoimentos', 'especialidades', 'visitante', 'ocupado'));
        }
        else{
            $depoimentos = DB::table('tb_depoimentos')
            ->join('tb_visitantes', 'cd_visitante', '=', 'fk_depoimento_visitante')
            ->where('fk_depoimento_consultor', '=', $id)
            ->orderBy('dt_depoimento', 'desc')
            ->paginate(3);
            $visitante = array();
            $visitante['qt_segundos'] = 1;
            return view('site/consultants/show', compact('consultores', 'depoimentos', 'especialidades', 'visitante', 'ocupado'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $consultores = Consultor::find($id);
        $consultores->dt_nascimento = date('d/m/Y', strtotime($consultores->dt_nascimento));
        $especialidades = Especialidade::all();
        $usuarios = User::where('cd_usuario_fk',$consultores->cd_consultor)->where('cd_role', 2)->get();
        $referencia = $especialidade = EspecialidadeConsultor::where('fk_especialidade_consultor','=', $consultores->cd_consultor)->get();
        return view('admin/consultor/edit', compact('consultores', 'especialidades', 'usuarios', 'referencia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, ImageRepository $repo)
    {
        $consultor = Consultor::find($id);
        $verifica = DB::table('tb_consultores')
            ->join('tb_usuarios', 'tb_usuarios.cd_usuario_fk', '=', 'tb_consultores.cd_consultor')
            ->where('tb_consultores.cd_consultor', '=', $id)->get();

        $rules = [
            'nome' => 'required|min:10|max:60',
            'cd_cpf' => 'required|cpf',
            'nascimento' => 'nullable|data',
            'sexo' => 'nullable',
            'email' => 'required|email',
            'celular' => 'nullable|min:10|max:11',
            'estado' => 'nullable',
            'cidade' => 'nullable|min:2|max:30',
            'observacoes' => 'nullable|max:60',
            'especialidade' => 'nullable',
            'status' => 'required',
            'foto' => 'nullable|image|file'
        ];

        $teste = $request['status'] = ($request->get('status') == "1") ? true : false;

        // Retira máscara
        $request['cd_cpf'] = preg_replace('/\D/', '', $request->get('cd_cpf'));
        $request['celular'] = preg_replace('/[^0-9]/','', $request->get('celular'));

        // Verifica duplicidade para update
        if($verifica[0]->email != $request->get('email')) $rules['email'] = 'required|email|unique:tb_usuarios';
        if($verifica[0]->cd_cpf != $request->get('cd_cpf')) $rules['cd_cpf'] = 'required|cpf|unique:tb_consultores';

        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O campo nome deve ter no mínimo 10 caracteres.',
            'nome.max' => 'O campo nome deve ter no máximo 60 caracteres.',
            'cd_cpf.required' => 'O campo cpf é obrigatório.',
            'cd_cpf.cpf' => 'Informe um cpf válido.',
            'cd_cpf.unique' => 'Este CPF já está cadastrado.',
            'nascimento.required' => 'O campo nascimento é obrigatório.',
            'nascimento.data' => 'Informe uma data válida.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.email' => 'Informe um email válido.',
            'celular.required' => 'O campo celular é obrigatório.',
            'celular.min' => 'O campo celular deve ter no mínimo 10 digitos',
            'celular.max' => 'O campo celular deve ter no máximo 11 digitos',
            'estado.required' => 'O campo estado é obrigatório.',
            'estado.digits' => 'O campo estado deve ter exatos 2 caracteres.',
            'cidade.required' => 'O campo cidade é obrigatório.',
            'cidade.min' => 'O campo cidade deve ter no mínimo 2 caracteres.',
            'cidade.max' => 'O campo cidade deve ter no máximo 30 caracteres.',
            'observacao.max' => 'O campo observação deve ter no máximo 60 caracteres.',
            'especialidade.required' => 'O campo especialidade é obrigatório.',
            'status.required' => 'O campo status é obrigatório.',
            'foto.image' => 'Imagem inválida.',
            'foto.file' => 'Imagem inválida.'
        ];

        $this->validate($request, $rules, $messages);

        // Transforma para a data correta mysql
        if($request['nascimento'] != "")  {
            $request['nascimento'] = date('Y-m-d',strtotime(str_replace('/','-',$request->get('nascimento'))));
        }

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
            $consultor->cd_cpf = $request->get('cd_cpf');
            $consultor->dt_nascimento = $request->get('nascimento');
            $consultor->ic_sexo = $request->get('sexo')=="1" ? "F" : "M";
            $consultor->cd_celular = $request->get('celular');
            $consultor->sg_estado = $request->get('estado');
            $consultor->nm_cidade = $request->get('cidade');
            $consultor->ds_observacao = $request->get('observacoes');
            $consultor->img_consultor = $userfoto;
            $consultor->save();

            // Altera a conta correspondente a este consultor
            $user = new \App\Http\Controllers\UsuarioController(new User);
            $user->update($request, $request->get('id_user'));

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
            return redirect('admin/consultor/editar/'.$consultor->cd_consultor)->with('error', 'Ocorreu um erro, Consultor não inserido');
        }

        return redirect('admin/consultor/editar/'.$consultor->cd_consultor)->with('success', 'Consultor Alterado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = Consultor::find($id);
        $resultado->delete();

        return redirect('admin/consultor/')->with('success', 'Consultor excluído');
    }

    public function recuperaSenha(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $messages = [
            'email.required' => 'Informe um e-mail.',
            'email.email' => 'Informe um e-mail válido.'
        ];

        $this->validate($request, $rules, $messages);

        try {
            $usuario = DB::table('tb_usuarios')
                ->select('cd_usuario_fk','cd_role')
                ->where('email','=',$request->get('email'))
                ->get();

            $info['tabela']="tb_consultores";
            $info['nome']="nm_consultor";
            $info['id']="tb_consultores.cd_consultor";

            $usuario = DB::table('tb_usuarios')
                ->join($info['tabela'], 'tb_usuarios.cd_usuario_fk', '=', $info['id'])
                ->select($info['nome'], 'password', 'email','cd_usuario_fk', 'cd_role', 'cd_usuario')
                ->where('email','=',$request->get('email'))
                ->get();

            $data['nome'] = $usuario[0]->nm_consultor;
            $data['senha'] = substr($usuario[0]->password, -6);
            $data['view'] = 'emails.senha';
            $data['subject'] = 'Recuperação de senha';
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Este e-mail não está registrado.');
        }

        \Mail::to($usuario[0]->email)->send(new EnviarEmail($data));
        if (Mail::failures()) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar o e-mail.');
        }

        $user = new \App\Http\Controllers\UsuarioController(new User);
        $user->mudaSenha($usuario[0]->cd_usuario, $data['senha']);

        return redirect()->back()->with('success', 'Dados enviados com sucesso!');
    }

}
