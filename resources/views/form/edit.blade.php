@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <header class="section-header">
        </header>

        <div class="row mb-8">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-8 content-end text-right">
                    <img src="{{ asset('img/qrcode.svg') }}" class="w-24 float-right ml-4" title="">
                    <p class="font-semibold text-lg">Acesso para responder</p>
                    <p class="text-md text-gray-500 mt-1">Para que outras pessoas possam responder, compartilhe o código QR ao lado ou o link baixo:</p>
                    <a href="{{ $reply_link }}" class="text-xl font-semibold text-blue-400" target="_blank">{{ $reply_link }}</a>
                </div>
            </div>
        </div>
        @livewire('form.edit', ['form' => $form])
    </div>
</section>
@endsection

@section('scripts')

<script>
    $(function () {
        PracticeForms.init({
            formId: '{{ $form->id }}',
            resultUrl: '{{ $result_json_url }}',
            repliesContainerId: 'replies',
            repliesBadgeContainerId: 'repliesBadge',
        });
    });
</script>

@endsection