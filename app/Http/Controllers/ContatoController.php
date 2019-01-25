<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Contato;
use App\Mail\EnviarEmail;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
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
    public function store(Request $request)
    {
        $rules = [
            'nome' => 'bail|required|min:10|max:100',
            'email' => 'bail|required|email|max:100',
            'telefone' => 'bail|required|min:10|max:11',
            'msg' => 'bail|required|min:50|max:1000'
        ];

        $messages = [
            'nome.required' => "O campo nome é obrigatório.",
            'nome.min' => "O campo nome deve conter no mínimo 10 caracteres.",
            'nome.max' => "O campo nome deve conter no máximo 100 caracteres.",
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'telefone.required' => "O campo telefone é obrigatório.",
            'telefone.min' => "O campo telefone deve conter no mínimo 10 caracteres.",
            'telefone.max' => "O campo telefone deve conter no máximo 11 caracteres.",
            'msg.required' => "O campo mensagem é obrigatório.",
            'msg.min' => "O campo mensagem deve conter no mínimo 50 caracteres.",
            'msg.max' => "O campo mensagem deve conter no máximo 1000 caracteres."
        ];

        $request['telefone'] = preg_replace('/[^0-9]/','', $request->get('telefone'));

        $this->validate($request, $rules, $messages);

        try{
            $data['nome'] = $request->nome;
            $data['email'] = $request->email;
            $data['telefone'] = $request->telefone;
            $data['msg'] = $request->msg;
            $data['view'] = 'emails.contato';
            $data['subject'] = 'Contato enviado por '.$request->email;
            
            $contato = new \App\Contato;
            $contato->nm_contato = $data['nome'];
            $contato->nm_email = $data['email'];
            $contato->cd_celular = $data['telefone'];
            $contato->ds_mensagem = $data['msg'];
            $contato->save();

            \Mail::to('leonardo.campos@kbrtec.com.br')->send(new EnviarEmail($data));
            if (Mail::failures()) {
                return redirect()->back()->with('error', 'Ocorreu um erro ao enviar o e-mail.');
            }

            return back()->with('success', 'Mensagem enviada com sucesso');
        }
        catch(Exception $e){
            return back()->withErrors('Erro ao enviar e-mail, tente novamente mais tarde');
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
        //
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
