@extends('layouts.base')
@section('content')

<section id="hero" class="hero hero-slim d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-5 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('img/undraw.co/my_answer.svg') }}" class="w-96 h-auto mx-auto" alt="">
            </div>
            <div class="col-7 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">Olá, tudo certo?</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">Vamos criar algo incrível hoje 🚀</h2>

                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                      <a style="background-color: #264653" href="{{ route('form.create') }}" class="btn-get-started d-inline-flex align-items-center justify-content-center align-self-center ">
                          <span>CRIAR</span>
                          <i class="bi bi-arrow-right-circle"></i>
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    @if (count($forms) > 0)
        <header class="section-header">
            <h2>Suas criações</h2>
        </header>

        <div class="row">
            <div class="col-12">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Título</th>
                            <th>Respostas</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>                
                    <tbody>
                        @foreach ($forms as $form)
                            <tr>
                                <td>
                                    <a href="{{ route('form.edit', [$form->id]) }}" class="btn btn-primary color-background-form">Ver</a>
                                </td>                                
                                <td>
                                    {{ $form->title ?? 'Questionário '.$form->id }}
                                </td>
                                <td>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                    </svg>
                                    {{ $form->replies()->count() }}
                                </td>
                                <td>
                                    <div>{{ $form->created_at }}</div>
                                    <div class="text-sm opacity-50">Última atualização: {{ $form->updated_at }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('form.delete', [$form->id ,$form->hash] ) }}" onclick="if (confirm('Tem certeza que deseja descartar este formulário?')){return true;}else{event.stopPropagation(); event.preventDefault();};" class="btn btn-danger">Remover</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection