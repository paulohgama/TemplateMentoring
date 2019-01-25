@extends('site.layouts.master')

@section('meta-title', 'Tarot Nova Era | Cartas ciganas, tarot, búzios, runas')
@section('meta-desc', '')

@section('content')

<!-- HEADER --> 
@include('site.homepage.sections.header')

<!-- CONSULTANTS -->
@include('site.homepage.sections.consultants')

<!-- HOW IT WORKS -->
@include('site.homepage.sections.how-it-works')


@endsection