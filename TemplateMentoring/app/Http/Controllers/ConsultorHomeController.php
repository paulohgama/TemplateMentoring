<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Consultor;
use \App\Especialidade;

use DB;

class ConsultorHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $consultores = new Consultor;
        $consultores = $consultores->join('tb_usuarios', 'cd_usuario_fk', '=', 'cd_consultor')->where('cd_role', '=', 2)->where('status', '=', 1)->where('dt_login','!=',null)->orderBy('dt_login', 'desc')->limit(6)->get();
        $especialidades = Especialidade::join('tb_especialidades_consultores', 'fk_consultor_especialidade', '=', 'cd_especialidade')->get();
        $consultoresAExibir = array();
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
            if(strlen($linhaConsultor['ds_consultor']) < 200) {
                $linhaConsultor['ds_consultor'] = nl2br(str_replace('<p>','',str_replace('</p>','',str_replace('<em>','',str_replace('</em>','',str_replace('<strong>','',str_replace('</strong>','',str_replace('<u>','',str_replace('</u>','',$linhaConsultor['ds_consultor'])))))))));
            } else {
                $linhaConsultor['ds_consultor'] = nl2br(substr(str_replace('<p>','',str_replace('</p>','',str_replace('<em>','',str_replace('</em>','',str_replace('<strong>','',str_replace('</strong>','',str_replace('<u>','',str_replace('</u>','',$linhaConsultor['ds_consultor'])))))))), 0, 176).'...');
            }

        }
        //Consultor::limit(6)->where('')->orderBy('dt_login', 'DESC')->get();
        return view('site.homepage.index', compact('consultores'));
    }
}