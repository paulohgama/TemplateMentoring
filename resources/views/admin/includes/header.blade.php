<header class="header">
    <nav class="flex-grid--wrap header__menu">
        <li class="flex-grid halign-center valign-middle admin-cp children-dashboard" data-active="true">
            <p> <strong>CP</strong> <span class="admin-cp__text">ADMIN</span></p>
        </li>
        <li class="menu__item open-aside" data-active="true"><i class="fa fa-bars item__inside flex-grid"></i></li>
        <ul class="flex-grid col menu-company"> {{--<li class="menu__item menu-site open-sub"><i class="fa fa-globe item__inside flex-grid"></i>
                <ul class="sub-menu--default flex-grid--col">
                    <li class="sub-menu__item"> <a href="{{ url('/') }}" target="_blank" class="sub-menu__inside" title="Ver site">Ver
                            site</a></li>
                </ul>
            </li>
            <li class="menu__item"><a href="{{ url('/admin/logout') }}" class="item__inside flex-grid" title="Sair"></a></li>
            --}}
        </ul>
        <ul class="flex-grid col-0 menu-user">
            <li class="menu__item active user-item open-sub">
                <figure class="item__inside flex-grid"><i class="fa fa-user flex-grid user-icon">
                        <figcaption class="user-legend">{{ Auth::user()->nome }}</figcaption>
                    </i></figure>
                <ul class="sub-menu--default flex-grid--col">
                    <li class="sub-menu__item sub-menu__inside"> <i class="fa fa-globe flex-grid"><a href="{{ url('/') }}"
                                target="_blank" class="item__inside sub-item__inside" title="Ver site">Ver site</a></i></li>
                    <li class="sub-menu__item sub-menu__inside"> <i class="fa fa-sign-out flex-grid"><a href="{{ url('/admin/logout') }}"
                                class="item__inside sub-item__inside" title="Sair">Sair</a></i></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
