<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendas;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $termo = $request->get('termo');
        $status = $request->get('status');
        $id_visitante = $request->get('id_visitante');
        $start = $request->get('start');
        $dados = $this->dadosAjax($termo, $status, $start, $id_visitante);
        $filtro = [
            'termo' => $termo,
        ];
        return View('admin.vendas.index', compact('dados', 'filtro', 'dados_especificos', 'request'));
    }

    public function dadosAjax($search = '', $status = '', $start = 0, $id = 0)
    {
        $vendas = Vendas::join('tb_visitantes', 'fk_vendas_visitante', '=', 'cd_visitante')
            ->offset($start)
                ->limit(10)
                ->orderBy('cd_venda', 'desc');
        if($search != null && $status != null) {
            $vendas->where('nm_visitante', 'like', "%{$search}%")
            ->where('st_status', '=', $status);
        }
        elseif($search != null && $status == null){
            $vendas->where('nm_visitante', 'like', "%{$search}%");
        }
        elseif($search == null && $status != null){
            $vendas->where('st_status', '=', $status);
        }
        if($id != 0){
            $vendas->where('cd_visitante', '=', $id);
        }
        $vendas = $vendas->paginate(10)
        ->appends(['status' => request('status')])
        ->appends(['termo' => request('termo')]);


        //dd($vendas);
        if($vendas) {
            foreach ($vendas as $dado) {
                $dado['st_status'] = $dado->st_status;
                for($i = 0; $i < count($vendas); $i++){
                    switch($vendas[$i]['st_status']){
                        case 1:
                            $vendas[$i]['st_status'] = "Aguardando Pagamento";
                            break;
                        case 2:
                            $vendas[$i]['st_status'] = "Paga";
                            break;
                    }
                }
            }
        }
        return $vendas;
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
