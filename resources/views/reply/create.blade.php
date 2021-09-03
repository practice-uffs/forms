@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <header class="section-header">
            <h2>Responder</h2>
            <p>{{ $form->title }}</p>
        </header>

        <div class="row mb-4">
            <div class="col-12 text-sm text-gray-400">
            </div>
        </div>

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