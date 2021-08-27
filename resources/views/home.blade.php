@extends('layouts.base')
@section('content')

<section id="hero" class="hero d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-5 hero-img" data-aos="zoom-out" data-aos-delay="200">
                <img src="{{ asset('img/undraw.co/happy_announcement.svg') }}" class="w-96 h-auto mx-auto" alt="">
            </div>
            <div class="col-7 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">Oi, tudo bem?</h1>
                <h2 data-aos="fade-up" data-aos-delay="400">Que bom que você está aqui novamente ❤️</h2>

                <div data-aos="fade-up" data-aos-delay="600">
                    <div class="text-center text-lg-start">
                      <a href="{{ route('form.create') }}" class="btn-get-started d-inline-flex align-items-center justify-content-center align-self-center">
                          <span>Criar uma enquete</span>
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
            <h2>Enquetes criadas por você</h2>
        </header>

        <div class="row">
            <div class="col-12">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Título</th>
                            <th>Situação</th>
                            <th>Data</th>
                            <th></th>
                        </tr>
                    </thead>                
                    <tbody>
                        @foreach ($forms as $form)
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar">
                                            <div class="w-10 h-10 mask mask-circle bg-{{ @$form->service->category->color }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mt-1 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">ddd</div>
                                            <div class="text-sm opacity-50">alguma coisa</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $form->title }}
                                </td>
                                <td>
                                    <span class="badge badge-outline badge-success badge-md">status</span>
                                </td>
                                <td>
                                    <div>{{ $form->created_at }}</div>
                                    <div class="text-sm opacity-50">Última atualização: {{ $form->updated_at }}</div>
                                </td>
                                <th>
                                    <a href="{{ route('form.edit', [$form->id]) }}" class="btn btn-primary">Ver detalhes</a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@endsection