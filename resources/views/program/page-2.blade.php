@extends('template/guest/main')
@section('title', 'Paket Pelatihan dan Sertifikasi Digital Marketing | ')
@section('content')

@php
$path=explode('/',Request::path());
@endphp

<div id="{{ $path[1] }}">
@include('program/header')
</div>

@endsection

@section('js-extra')
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script type="text/javascript" src="{{asset('assets/js/app.js')}}"></script>
@endsection