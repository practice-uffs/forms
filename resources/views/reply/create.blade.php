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
@endsection


<section>
    <div class="container">
        @section("FormHeader")
        <header class="section-header bg-white pt-20 mt-20">
            <div class="d-block w-100 mb-10">
                <div class="container w-100 mr-auto ml-auto h-auto"><h2 class="float-right h-auto pr-2"><strong>{{ str_replace('-', '/', date('d-m-Y')) }}</strong></h2></div>
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
    $(function () {
       
        ProgressBar.init({
            countFields : {{count($form->questions)}},
            answeredFields : [],
            totalAnsweredFields : 0,

            containerId : 'ProgressBarElement',
            counterId : 'ProgressBarCounter',
            containerWidth : 1,
        });
    });
</script>

@endsection