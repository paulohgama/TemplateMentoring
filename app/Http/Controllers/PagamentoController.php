<?php
//header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendas;
use App\Visitante;
use Illuminate\Support\Facades\Auth;
use App\Valor;

class PagamentoController extends Controller
{
    public function EfetuarPagamento(Request $request)
    {
        $vendas = new Vendas([
            'dt_venda' => date('Y-m-d'),
            'fk_vendas_visitante' => $request->visitante,
            'cd_compra' => $request->preco,
            'st_status' => 1,
            'qt_minutos_compra' => $request->minutos
        ]);
        $vendas->save();
        $dados = array();
        $dados['email'] = 'danton.lima@kbrtec.com.br';
        $dados['token'] = '22EA06CA540C4CB1BC92F9084183A2FC';
        $dados['currency'] = 'BRL';
        $dados['itemId1'] = '1';
        $dados['itemDescription1'] = $request->minutos.' minutos comprados';
        $dados['itemAmount1'] = number_format($request->valor, 2, ".", "");
        $dados['itemQuantity1'] = $request->minutos;
        $dados['reference'] = $vendas->cd_venda;

        $code = $this->Finalizar($dados);
        return json_encode(array('code' => $code));
    }

    public function Finalizar($dados)
    {
        $buildQuery = http_build_query($dados);
        $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/checkout";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $buildQuery);

        $retorno = curl_exec($curl);
        curl_close($curl);

        $xml = simplexml_load_string($retorno);
        $code = $xml->code;
        return $code;
    }

    public function telaPagamento(Request $request)
    {
        $totalminutos = $request->totalminutes;
        if($totalminutos < 1)
        {
            return back()->with('creditozero', 'creditozero');
        }
        $valor = Valor::orderBy('dt_mudanca', 'desc')->first();
        $preco = $totalminutos;
        $totalminutos = $preco / $valor->valor;
        return redirect('/pagamento')->with(array('valor' => number_format($valor->valor, 2, ',', '.'), 'preco' => number_format($preco, 2, ',', '.'), 'minutos' => $totalminutos));
    }

    public function telaCompra()
    {
        $valor = Valor::orderBy('dt_mudanca', 'desc')->first();
        $val = $valor->valor;
        return view('site.buy-minutes.index', compact('val'));
    }

    public function status($status, $transaction){

        switch ($status) {
            case 1:
                $venda = Vendas::find($transaction->reference);
                $venda->st_status = $status;
                $venda->update();
                break;
            case 3:
                $venda = Vendas::find($transaction->reference);
                $venda->st_status = 2;
                $venda->update();
                $visitante = Visitante::find($venda->fk_vendas_visitante);
                $visitante->qt_segundos = ($venda->qt_minutos_compra * 60);
                $visitante->update();
                break;
            default:
            exit;
            break;
        }
    }

    public function notificacao(Request $request){
        define("EMAIL_PAGSEGURO", "danton.lima@kbrtec.com.br");
        define("TOKEN_PAGSEGURO", "");
        define("TOKEN_SANDBOX", "22EA06CA540C4CB1BC92F9084183A2FC");
        if(true){
            $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/".$request->notificationCode."?email=".EMAIL_PAGSEGURO."&token=".TOKEN_SANDBOX."";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $transacao = curl_exec($curl);
            if($transacao == 'Unauthorized'){
                exit;
            }
            curl_close($curl);
            $transaction = simplexml_load_string($transacao);
            $status = $transaction->status;
            return $this->status($status, $transaction);
        }
    }
}
