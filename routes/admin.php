<?php
Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    /**
     * ---------------------------------------------------------------------
     *  Visitor Routes
     * ---------------------------------------------------------------------
     */
    Route::group(['namespace' => 'Auth'], function () {
        /**
         * ---------------------------------------------------------------------
         *  Login Routes
         * ---------------------------------------------------------------------
         */
        Route::get('/login', function(){
            return view('admin.login.login');
        });

        Route::get('/logout', 'LoginController@logout')->middleware('admin');
    });

    /**
     * ---------------------------------------------------------------------
     *  Authenticated Routes
     * ---------------------------------------------------------------------
     */
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', function(){
            return view('admin.home.index');
        });

        #region Visitante
        Route::group(['namespace' => 'Visitante', 'prefix' => 'Visitante'], function () {
            Route::get('/', 'VisitanteController@index');
            Route::get('/visualizar/{id}', 'VisitanteController@show');
            Route::get('/cadastrar', 'VisitanteController@create');
            Route::get('/editar/{id}', 'VisitanteController@edit');
            Route::get('/excluir/{id}', 'VisitanteController@destroy');
            Route::get('/destaques', 'VisitanteController@destaques');

            Route::post('/cadastrar', 'VisitanteController@store');
            Route::post('/editar/{id}', 'VisitanteController@update');
            Route::post('/destaques', 'VisitanteController@storeDestaques');

            Route::put('/alterar-status', 'VisitanteController@changeStatus');
        });
        #endregion

        #region Contato
        Route::group(['namespace' => 'Contato', 'prefix' => 'contato'], function () {
            Route::get('/', 'ContatoController@index');
            Route::get('/visualizar/{id}', 'ContatoController@show');
            Route::get('/excluir/{id}', 'ContatoController@destroy');
        });
        #endregion

        #region Depoimento
        Route::group(['namespace' => 'Depoimento', 'prefix' => 'depoimento'], function () {
            Route::get('/', 'DepoimentoController@index');
            Route::get('/visualizar/{id}', 'DepoimentoController@show');
            Route::get('/cadastrar', 'DepoimentoController@create');
            Route::get('/editar/{id}', 'DepoimentoController@edit');
            Route::get('/excluir/{id}', 'DepoimentoController@destroy');
            Route::get('/destaques', 'DepoimentoController@destaques');

            Route::post('/cadastrar', 'DepoimentoController@store');
            Route::post('/editar/{id}', 'DepoimentoController@update');
            Route::post('/destaques', 'DepoimentoController@storeDestaques');

            Route::put('/alterar-status', 'DepoimentoController@changeStatus');


        });
        #endregion

        #region FAQ
        Route::group(['namespace' => 'Faq', 'prefix' => 'faq'], function () {
            Route::get('/', 'FaqController@index');
            Route::get('/visualizar/{id}', 'FaqController@show');
            Route::get('/cadastrar', 'FaqController@create');
            Route::get('/editar/{id}', 'FaqController@edit');
            Route::get('/excluir/{id}', 'FaqController@destroy');

            Route::post('/cadastrar', 'FaqController@store');
            Route::post('/editar/{id}', 'FaqController@update');

            Route::put('/alterar-status', 'FaqController@changeStatus');

            Route::group(['prefix' => 'categoria'], function () {
                Route::get('/', 'FaqCategoriaController@index');
                Route::get('/visualizar/{id}', 'FaqCategoriaController@show');
                Route::get('/cadastrar', 'FaqCategoriaController@create');
                Route::get('/editar/{id}', 'FaqCategoriaController@edit');
                Route::get('/excluir/{id}', 'FaqCategoriaController@destroy');

                Route::post('/cadastrar', 'FaqCategoriaController@store');
                Route::post('/editar/{id}', 'FaqCategoriaController@update');
            });
        });
        #endregion

        #region Parceiros
        Route::group(['namespace' => 'Parceiro', 'prefix' => 'parceiro'], function () {
            Route::get('/', 'ParceiroController@index');
            Route::get('/visualizar/{id}', 'ParceiroController@show');
            Route::get('/cadastrar', 'ParceiroController@create');
            Route::get('/editar/{id}', 'ParceiroController@edit');
            Route::get('/excluir/{id}', 'ParceiroController@destroy');

            Route::post('/cadastrar', 'ParceiroController@store');
            Route::post('/editar/{id}', 'ParceiroController@update');

            Route::put('/alterar-status', 'ParceiroController@changeStatus');

            Route::group(['prefix' => 'categoria'], function () {
                Route::get('/', 'ParceiroCategoriaController@index');
                Route::get('/visualizar/{id}', 'ParceiroCategoriaController@show');
                Route::get('/cadastrar', 'ParceiroCategoriaController@create');
                Route::get('/editar/{id}', 'ParceiroCategoriaController@edit');
                Route::get('/excluir/{id}', 'ParceiroCategoriaController@destroy');

                Route::post('/cadastrar', 'ParceiroCategoriaController@store');
                Route::post('/editar/{id}', 'ParceiroCategoriaController@update');
            });
        });
        #endregion


        #region Slide
        Route::group(['namespace' => 'Slide', 'prefix' => 'slide'], function () {
            Route::get('/', 'SlideController@index');
            Route::get('/visualizar/{id}', 'SlideController@show');
            Route::get('/cadastrar', 'SlideController@create');
            Route::get('/editar/{id}', 'SlideController@edit');
            Route::get('/excluir/{id}', 'SlideController@destroy');

            Route::post('/cadastrar', 'SlideController@store');
            Route::post('/editar/{id}', 'SlideController@update');

            Route::put('/alterar-status', 'SlideController@changeStatus');
        });
        #endregion
    });
});
?>
