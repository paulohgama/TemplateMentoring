@if ($errors->all()) <span class="alert--warning">{{ $errors->first() }}</span> @elseif (Session::has('error')) <span
    class="alert--danger">{{ Session::get('error') }}</span> @elseif (Session::has('success')) <span class="alert--success">{{
    Session::get('success') }}</span> @endif
