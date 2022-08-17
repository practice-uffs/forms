@extends('layouts.base')
@section('content')


@section('ProgressBar')
    <div class="container pl-5 pr-5">
        <h2 class="mb-1 mt-1 fw-bolder position-absolute" style="color: var(--dark-blue-color)">Questões Respondidas</h2>
        <h2 class="mb-1 mt-1 fw-bolder float-right" style="color: var(--dark-blue-color)" id="ProgressBarCounter">0%</h2>
        <div class="rounded overflow-hidden border w-100" style="background-color: var(--body-default-color);">
            <div id="ProgressBarElement" class="bg-success opacity float-left w-5 mw-10 h-5 progress-bar-striped"></div>
        </div>
    </div>
    <div class="container w-100 mr-auto ml-auto h-auto" style="color: #4154f1 !important">
        <h1 class="float-right d-flex align-items-center h-10 pr-2">
            <strong>{{ str_replace('-', '/', date('d-m-Y')) }}</strong>
            @if($form->timer == true)
                <strong class="ml-2 pl-2 border-start" id="time_counter">{{ $form->timer ? 'Iniciando contagem' : ''}}</strong>
                <button type="button" class="btn-danger p-2 pt-1 pb-1 br-5 ml-2 float-right rounded" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Tempo limte para responder!">!</button>
            @endif
        </h1>
    </div>
@endsection


<section>
    <div class="container">
        @section("FormHeader")
        <header class="section-header bg-white pt-20 mt-20">
            <div class="d-block w-100 mb-10">
                <h2 class="w-100 position-absolute">Responder</h2>
            </div>
            <p class="d-block p-2">{{ $form->title }}</p> 
        </header>
        @endsection
        <div class="row">
            <div class="col-12">
                @livewire('reply.create', [
                    'model' => 'App\Model\Reply',
                    'form' => $form,
                    'show_list' => false,
                    'include_create' => [
                        'user_id' => auth()->id(),
                        'form_id' => $form->id
                    ]
                ])
            </div>
        </div>
    </div>
@endsection

@section('scripts')

<script>
    document.documentElement.style.setProperty('--body-default-color', '#f1f0ef');

    var timer = {{$form->timer}};
    function start_time_counter(date_to_answer, time_to_answer){
        //data fim para submissão do formulário
        var final_date = new Date(date_to_answer+' '+time_to_answer)

        // Atualiza a cada 1 segundo
        var x = setInterval(function() {

            // cria data atual
            var now = new Date();
            
            // calcula o intervalo
            var interval = final_date - now;

            var days = Math.floor(interval / (1000 * 60 * 60 * 24));
            var hours = Math.floor((interval % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((interval % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((interval % (1000 * 60)) / 1000);

            // altera contador no elemento html
            document.getElementById("time_counter").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

            // condição de parada com submissão do formulário
            if (interval < 0) {
                clearInterval(x);
                document.getElementById("time_counter").innerHTML = "Seu tempo expirou";

                
                $('#btn-store').click();
            }
        }, 1000);


    };

    $(function () {
       
        ProgressBar.init({
            countFields : {{count($form->questions)}},
            answeredFields : [],
            totalAnsweredFields : 0,

            containerId : 'ProgressBarElement',
            counterId : 'ProgressBarCounter',
            containerWidth : 1,
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })



        if(timer){
            if (confirm('Questionário com tempo limite, clique em ok para iniciar a contagem!')) {
                start_time_counter('{{$form->date_to_answer}}', '{{$form->time_to_answer}}');
            } else {
                alert('Você precisa confirmar para continuar visualizando este questionário!');
                window.location.reload();
            }
        }
        

    });



</script>

@endsection