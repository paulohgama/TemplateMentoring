<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head> @include('admin.includes.partial-head')</head>

<body class="body">

     @include('admin.includes.header')
<main class="main flex-grid col"> @include('admin.includes.aside')
        @yield('content')</main> @include('admin.includes.scripts')

        <script type="text/javascript">
                if(window.location.pathname === '/admin/transferencias/pendentes')
                {
                    localStorage.removeItem('pesquisareal');
                }
                else if(window.location.pathname === '/admin/transferencias/realizadas')
                {
                    localStorage.removeItem('pesquisapendente');
                }
                else
                {
                    localStorage.removeItem('pesquisapendente');
                    localStorage.removeItem('pesquisareal');
                }
    </script>
    </body>

</html>
