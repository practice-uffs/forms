@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <header class="section-header">
            <h2>Solicitação de serviço</h2>
        </header>

        <div class="row mb-4">
            <div class="col-10 offset-1 text-sm text-gray-400">
                <strong>Resumo do serviço</strong>
                <p>ddsd</p>
            </div>
        </div>

        <div class="row">
            <div class="col-10 offset-1">
                @livewire('form.edit', [
                    'model' => 'App\Model\Form',
                    'edit' => $form,
                    'show_list' => false,
                    'include_create' => [
                        'user_id' => auth()->id(),
                    ]
                ])
            </div>
        </div>
    </div>
@endsection