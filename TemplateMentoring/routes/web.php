<?php
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckVisitante;
use App\Http\Middleware\CheckConsultor;
//Painel admin
Route::group(['prefix' => 'admin', 'middleware' => CheckAdmin::class], function () {
    Route::get('/', function () {
        return view('admin.home.index');
    });

    Route::get('/logout', 'UsuarioController@logout');

    Route::group(['prefix' => 'consultor'], function () {
        // CRUD Consultor
        Route::get('/listar', 'ConsultorController@index');
        Route::get('/cadastrar', 'ConsultorController@create');
        Route::post('/armazenar', 'ConsultorController@store');
        Route::get('/editar/{id}', 'ConsultorController@edit');
        Route::patch('/atualizar/{id}', 'ConsultorController@update');
        Route::get('/excluir/{id}', 'ConsultorController@destroy');
        Route::get('/visualizar/{id}', 'ConsultorController@show');
    });

    Route::group(['prefix' => 'especialidade'], function () {
        // Crud especialidade
        Route::get('/listar', 'EspecialidadeController@index');
        Route::get('/cadastrar', 'EspecialidadeController@create');
        Route::post('/armazenar', 'EspecialidadeController@store');
        Route::get('/editar/{id}', 'EspecialidadeController@edit');
        Route::patch('/atualizar/{id}', 'EspecialidadeController@update');
        Route::get('/excluir/{id}', 'EspecialidadeController@destroy');

    });

    Route::group(['prefix' => 'visitante'], function () {
        Route::get('/', 'VisitanteController@index');
        Route::get('/visualizar/{id}', 'VisitanteController@show');
        Route::get('/cadastrar', 'VisitanteController@create');
        Route::get('/editar/{id}', 'VisitanteController@edit');

        Route::post('/cadastrar', 'VisitanteController@store');
        Route::post('/editar/{id}', 'VisitanteController@update');
    });

    // Relatório de Vendas
    Route::group(['prefix' => 'vendas'], function () {
        Route::get('/relatorio', 'VendaController@index');
        Route::get('relatorio/exibicao', function(){
            return view('admin.vendas.index');
        });
        Route::post('/relatorio/dados', "VendaController@dadosEspecificos")->name('venda.unica');
        Route::get('/relatorio/filtro', "VendaController@index")->name('filtro.status');
     });

     //Relatorio de Creditos
    Route::group(['prefix' => 'transferencias'], function () {
        Route::get('/pendentes', function()
        {
            return view('admin.transferencias.pendentes');
        })->name('transf.pend');
        Route::get('/realizadas', function()
        {
            return view('admin.transferencias.realizadas');
        })->name('transf.real');
        Route::post('/pendentes/dados', 'TransferenciaController@Pendentes')->name('admin.transf.pendentens');
        Route::post('/pendentes/dadosrealizados', 'TransferenciaController@Realizados')->name('admin.transf.realizados');
        Route::post('/pendentes/dadosConsultor', 'TransferenciaController@PendenteConsultor')->name('admin.transf.pendentes.consultor');
        Route::get('/pendentes/darbaixa', 'TransferenciaController@DarBaixa')->name('admin.transf.pendentes.darbaixa');

    });

    Route::group(['prefix' => 'atendimento'], function () {
        Route::get('/', 'AtendimentoController@index')->name('admin.atendimento.index');
        Route::get('/visualizar/{id}', 'AtendimentoController@show');
        Route::get('/cadastrar', 'ValorController@create');

        Route::post('/cadastrar', 'ValorController@store');
    });
});



Route::get('/', 'ConsultorHomeController@index');

Route::get('/contato', function() {
    return view('site.contact');
});

Route::group(['middleware' => CheckVisitante::class], function () {
    Route::get('/comprar-minutos', "PagamentoController@telaCompra");
    Route::get('/pagamento', function() {
        return view('site.buy-minutes.payment');
    });
    Route::post('/pag', "PagamentoController@telaPagamento")->name('pagamento.finalizar');
    Route::get('/chat-visitante/{id}', 'AtendimentoController@store');
    Route::post('/token-pagseguro', 'PagamentoController@EfetuarPagamento')->name('pegar.token');
});

Route::any('/notificacao','PagamentoController@notificacao');

Route::post('/Depoimento','DepoimentosController@store');

//Login visitante
Route::get('/login', function() {
    return view('site.login');
});

//Login admin
Route::get('/admin/login', function() {
    return view('admin.login.login');
});

//Login Consultor
Route::get('/painel-consultor/login', function(){
    return view('painel-consultor.auth.login');
});

Route::get('/recuperar-senha', function() {
    return view('site.password-recovery');
});

//Visitante
Route::get('/visitante', 'SiteVisitanteController@index');

Route::get('/visitante/alterar-cadastro', function() {
    return view('site.visitor.alter-register');
});


Route::post('/Enviar', 'ContatoController@store');
Route::post('/login', 'UsuarioController@logar');
Route::post('/logout', 'UsuarioController@logout')->name('logout');

Route::post('/cadastrar', 'VisitanteController@Store');
Route::get('/editar/{id}', 'SiteVisitanteController@edit')->name('visitante.alterar');
Route::post('/atualizar/{id}', 'SiteVisitanteController@update')->name('visitante.atualizar');

Route::post('/loginAdmin', 'UsuarioController@logarAdmin')->name('admin.login');
Route::post('/loginConsultor', 'UsuarioController@logarConsultor')->name('consultor.login');
Route::get('/cadastro', function () {
    return view('cadastrovisitante');
});

Route::get('/consultores', 'ConsultorController@indexSite');

Route::get('/consultores/show/{id}', 'ConsultorController@show');

Route::get('/email-template', function () {
    return view('emails.exemplo');
});

//Painel Consultor
Route::group(['prefix' => 'painel-consultor', 'middleware' => CheckConsultor::class], function () {
    Route::get('/', 'DashBoardConsultorController@index');
    //Atualizar status
    Route::get('/', 'DashBoardConsultorController@alteraStatus')->name('altera.status');
    Route::get('/dados', 'DashBoardConsultorController@alteraStatusAjax')->name('altera.status.ajax');
    //Chat
    Route::get('/chat-consultor/{id}', 'AtendimentoController@updateConsultor');
    //Minha conta
    Route::get('/minha-conta/alterar-cadastro', 'DashBoardConsultorController@edit');
    Route::post('/minha-conta/alterar-cadastro', 'DashBoardConsultorController@alteraCadastro')->name('altera.cadastro');

    Route::get('/minha-conta/alterar-senha', function(){
        return view('painel-consultor.minha-conta.alterar-senha');
    });
    Route::post('/minha-conta/alterar-senha', 'DashBoardConsultorController@alteraSenha')->name('altera.senha');

    Route::get('users/{id}', function ($id) {

    });

    //atendimento
    Route::get('/atendimento/relatorios', 'AtendimentoController@index')->name('atendimento.relatorio');
    Route::get('/atendimento/visualizar/{id}', 'AtendimentoController@show');
    Route::get('/atendimento/visualizar', function(){
        return view('painel-consultor.atendimento.visualizar');
    });

    Route::get('/relatorio-creditos-e-transferencias', 'TransferenciasConsultorController@index')->name('credito.transferencia.index');

});

Route::get('/visitante/minha-conta/alterar-senha', function(){
    return view('site.visitor.alter-password');
});

Route::post('/visitante/minha-conta/alterar-senha', 'DashBoardConsultorController@alteraSenha')->name('altera.senha');

Route::get('/painel-consultor/recuperar-senha', function(){
    return view('painel-consultor.auth.recuperar-senha');
});

Route::post('/painel-consultor/recuperar-senha', 'ConsultorController@recuperaSenha');

Route::get('/recuperar-senha', function(){
    return view('painel-consultor.auth.recuperar-senha');
});

Route::post('/visitante/recuperar-senha', 'ConsultorController@recuperaSenha');

// Especialidade
Route::resource('especialidade', 'EspecialidadeController');

// Painel Admin
Route::resource('consultor', 'ConsultorController');
Route::post('/dadosAjax', 'ConsultorController@dadosAjax')->name('dadosAjax');

Route::resource('especialidade', 'EspecialidadeController');

Route::get('relatorio', 'VendaController@relatorioDeVendas');
Route::post('/mensagem', 'MensagemController@store');
Route::post('/finalizar', 'AtendimentoController@updateFinal')->name('finalizar');

