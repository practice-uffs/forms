@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <div class="row mt-20">
            <div class="col-12">
                <img src="{{ asset('img/undraw.co/walk_dreaming.svg') }}" title="Um urso triste" class="w-72 h-auto m-auto" />
            </div>
        </div>

        <header class="section-header mt-10">
            <p>Você não pode responder</p>
        </header>

        <div class="row mb-4 text-center">
            <div class="col-12">
                <p>Infelizmente você não pode responder esse questionário.<br />Talvez uma próxima, né?</p>
                <p class="mt-20"><a href="{{ route('index') }}" class="link link-primary">Voltar à página inicial</a></p>
            </div>
        </div>
    </div>
@endsection