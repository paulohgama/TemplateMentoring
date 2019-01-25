<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use \App\Especialidade;

class EspecialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(Especialidade $especialidade){
        $this->especialidade = $especialidade;

    }

    public function index()
    {
        $especialidades = new Especialidade;

        if(request('termo') != '') {
            $especialidades = $especialidades->where('nm_especialidade', 'LIKE', '%'.request('termo').'%')
                ->orWhere('cd_especialidade',request('termo'))
                ->orderBy('cd_especialidade', 'DESC')
                ->paginate(10)->appends('termo', request('termo'));
        } else {
            $especialidades = $especialidades->orderBy('cd_especialidade', 'DESC')->paginate(10);
        }

        return View('admin.especialidade.index')->with([
            'lista' => $especialidades
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/especialidade/create');
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
            'nm_especialidade' => 'required|unique:tb_especialidades|min:6|max:30'
        ];

        $messages = [
            'required' => 'O campo especialidade é obrigatório.',
            'unique' => 'Esta especialidade já está cadastrada.',
            'min' => 'O campo especialidade deve ter no mínimo 6 caracteres.',
            'max' => 'O campo especialidade deve ter no mínimo 30 caracteres.',
        ];

        $this->validate($request, $rules, $messages);

        $especialidade = new Especialidade([
            'nm_especialidade' => $request->get('nm_especialidade')
        ]);
        $especialidade->save();
        return redirect('admin/especialidade/cadastrar')->with('success', 'Especialidade Inserida');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resultado = Especialidade::find($id);
        return view('admin/especialidade/index', compact("resultado"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resultado = Especialidade::find($id);

        return view('admin/especialidade/edit', compact('resultado'));
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
        $esp = Especialidade::find($id);

        $rules = [
            'nm_especialidade' => 'required|min:6|max:30'
        ];

        $messages = [
            'required' => 'O campo especialidade é obrigatório.',
            'unique' => 'Esta especialidade já está cadastrada.',
            'min' => 'O campo especialidade deve ter no mínimo 6 caracteres.',
            'max' => 'O campo especialidade deve ter no mínimo 30 caracteres.',
        ];

        if($esp->nm_especialidade != $request->get('nm_especialidade')) {
            $rules['nm_especialidade'] = 'required|unique:tb_especialidades|min:6|max:30';
        }

        $this->validate($request, $rules, $messages);

        $resultado = Especialidade::find($id);
        $resultado->nm_especialidade = $request->get('nm_especialidade');
        $resultado->save();

        return redirect('admin/especialidade/listar')->with('success', 'Especialidade alterada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $resultado = Especialidade::find($id);
            $resultado->delete();
            return redirect('admin/especialidade/listar')->with('success', 'Especialidade excluída');
        } catch(Exception $e) {
            return redirect('admin/especialidade/listar')->with('error', 'Não foi possível excluir. Há consultor(es) relacionado(s) a esta especialidade.');
        }
    }
}
