@extends('layouts.base')
@section('content')

@section('styles')
<link href="{{ asset('css/demo-chart.css') }}" rel="stylesheet">
@endsection

@section('wideTopContent')
    <div class="float-cube-area">
        <ul class="float-cube">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
@endsection

<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-2 pt-10 pb-0 md:flex-row flex-col items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start text-left items-center">
            <h1 data-aos="fade-up" class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                Perguntas e respostas. <br class="hidden lg:inline-block"><span class="sm:text-4xl text-3xl font-light mt-5">Prático e muito, muito fácil.</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="400" class="mb-8 leading-relaxed">
                Criar questionários não precisa ser complicado. Já imaginou escrever em texto corrido e ter um formulário pronto para uso (com o que o digital tem a oferecer)?
                Basta compartilhar um link e receber respostas (com acompanhamento em tempo real). Chega de sofrer: crie formulários, enquetes e afins usando o <span class="text-blue-700 font-semibold">PRACTICE Forms</span>.
            </p>
            <div data-aos="fade-up" data-aos-delay="600" class="flex justify-center">
                <a href="{{ route('form.create') }}">
                    <div style="background-color: #264653" tabindex="0" class="btn btn-primary inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg color-background-form">
                        Criar
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </a>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6  md:mb-0 mt-10 mb-10 md:mt-0" data-aos="zoom-out" data-aos-delay="200">
            <img class="object-cover object-center w-full" alt="hero" src="{{ asset('img/manypixels.co/information-flow.svg') }}">
        </div>        
    </div>
</section>

<section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-2 pb-5 md:flex-row flex-col items-center">
        <div class="lg:flex-grow lg:pl-24 md:pl-16 flex flex-col md:items-start self-center items-center text-center" data-aos="zoom-out" data-aos-delay="200">
            <h1 data-aos="fade-up" class="m-auto title-font sm:text-4xl text-3xl mb-4 font-light text-gray-900">
                Texto é sua ferramenta
                <br class="hidden lg:inline-block">
            </h1>
            <p data-aos="fade-up" data-aos-delay="200" class="leading-relaxed text-center md:w-50 m-auto">
                Escreva perguntas como se fosse enviar um e-mail. Deixe o <span class="text-blue-700 font-semibold">PRACTICE Forms</span> transformar esse texto em um questionário digital. Quer perguntas abertas? Múltipla escolha? Likert? Envio de arquivos? Temos todos os tipos.
            </p>

            <p data-aos="fade-up" data-aos-delay="200" class="pt-5 font-semibold text-center w-100 md:w-1/2 m-auto">
                Experimente! Teste a criação de perguntas via texto abaixo.
            </p>
        </div>
    </div>
    <div class="w-full" x-data="{ demo: true}">
        @livewire('demo.show')
    </div>
</section>

<section class="text-gray-600 body-font">
    <div class="container mx-auto flex md:flex-row flex-col items-center">
        <div class="lg:max-w-lg lg:w-full w-100 mb-10" data-aos="zoom-out">
            @include('components.demo-chart')
        </div>
        <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start text-left items-center">
            <h1 data-aos="fade-up" class="title-font sm:text-4xl text-3xl mb-4 font-light text-gray-900">
                Visualização de resultados 
                <br class="hidden lg:inline-block">
            </h1>
            <p data-aos="fade-up" class="mb-8 leading-relaxed">
                Mais importante que suas perguntas são as respostas recebidas. Veja em tempo real as respostas do seu questionário. Faça relatórios, transforme gráficos em figuras para baixar. Lembra que falamos em ser fácil?
            </p>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    var chartDemo = document.getElementsByClassName('chart-demo')[0];

    setInterval(function() {
        if (chartDemo.classList.contains('loaded')) {
            chartDemo.classList.remove('loaded');
        } else {
            chartDemo.classList.add('loaded');
        }
    }, 1500);

</script>
@endsection