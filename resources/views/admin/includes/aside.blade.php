<aside class="aside aside-menu col-12" data-active="true">
    <ul class="flex-grid--wrap dashboard">
        <div class="col-12 dashboard-company pd-10"><a href="{{ url('/admin') }}" title="Dashboard">
                <figure class="flex-grid pd-10--top pd-10--bottom valign-middle halign-center">
                    <image class="col-6" src="{{ url('/images/logo-admin-colorfull.png') }}" style="height: width: 80px; flex: none;"
                        alt="" />
                </figure>
            </a></div>
        <p class="dashboard-hidden col-12 pd-10 dashboard-title">MENU PRINCIPAL</p>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box"><i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Visitantes</p><span class="flex-grid arrow dashboard-hidden col self-middle halign-right"><i
                            class="fa fa-angle-left"></i></span>
                </div>
                <ul class="options">
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ url('/admin/visitante') }}" class="link--white">Gerenciar</a></li>
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ url('/admin/visitante/cadastrar') }}"
                            class="link--white">Cadastrar</a></li>
                </ul>
            </div>
        </li>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box">
                    <i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Consultores</p>
                    <span class="flex-grid arrow dashboard-hidden col self-middle halign-right">
                        <i class="fa fa-angle-left"></i>
                    </span>
                </div>
                <ul class="options">
                    <li class="options-item">
                        <i class="fa fa-link"></i>
                        <a href="{{ url("admin/consultor/listar") }}" class="link--white">Gerenciar</a>
                    </li>
                    <li class="options-item">
                        <i class="fa fa-link"></i>
                        <a href="{{ url("admin/consultor/cadastrar") }}" class="link--white">Cadastrar</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box">
                    <i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Especialidade</p>
                    <span class="flex-grid arrow dashboard-hidden col self-middle halign-right">
                        <i class="fa fa-angle-left"></i>
                    </span>
                </div>
                <ul class="options">
                    <li class="options-item">
                        <i class="fa fa-link"></i>
                        <a href="{{ url("admin/especialidade/listar") }}" class="link--white">Gerenciar</a>
                    </li>
                    <li class="options-item">
                        <i class="fa fa-link"></i>
                        <a href="{{ url("admin/especialidade/cadastrar") }}" class="link--white">Cadastrar</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box"><i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Vendas</p><span class="flex-grid arrow dashboard-hidden col self-middle halign-right"><i
                            class="fa fa-angle-left"></i></span>
                </div>
                <ul class="options">
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ url('/admin/vendas/relatorio/') }}" class="link--white">Relatório</a></li>
                </ul>
            </div>
        </li>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box"><i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Transferencias</p><span class="flex-grid arrow dashboard-hidden col self-middle halign-right"><i
                            class="fa fa-angle-left"></i></span>
                </div>
                <ul class="options">
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ route('transf.pend') }}" class="link--white">Pendentes</a></li>
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ route('transf.real') }}" class="link--white">Realizadas</a></li>
                </ul>
            </div>
        </li>
        <li class="flex-grid open-options">
            <div class="flex-grid dashboard-item">
                <div class="flex-grid dashboard-box"><i class="dashboard-shorter-icon fa fa-paperclip"></i>
                    <p class="dashboard-shorter-item item-name">Atendimento</p><span class="flex-grid arrow dashboard-hidden col self-middle halign-right"><i
                            class="fa fa-angle-left"></i></span>
                </div>
                <ul class="options">
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ url('/admin/atendimento/cadastrar') }}" class="link--white">Mudar valor</a></li>
                    <li class="options-item"><i class="fa fa-link"></i> <a href="{{ url('/admin/atendimento/') }}"
                            class="link--white">Relatório de atendimentos</a></li>
                </ul>
            </div>
        </li>
    </ul>
</aside>
