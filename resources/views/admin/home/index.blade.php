@extends('admin.layout.master') @section('title', 'Dashboard') @section('content')
<section class="main__content content home flex-grid--wrap col calign-top">
    <div class="flex-grid--row-rev--wrap col-12 calign-top mg-30--bottom">
        <h1 class="col light font-30 main-title is-sm">Dashboard</h1>
    </div>
    <div class="flex-grid--wrap content__box--first nopadding col-12"> @include('admin.includes.messages')<br /></div>
</section> @endsection
