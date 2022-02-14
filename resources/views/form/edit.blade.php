@extends('layouts.base')
@section('content')


<section>
    <div x-data="{enlarge: false}" class="container">
        <header class="section-header">
        </header>

        <div class="absolute top-0 left-0 z-20 w-screen h-screen bg-white pointer-events-none flex items-center justify-center" x-show="enlarge">
            <div class="m-auto custom-svg-expanded">
                {!! QrCode::size(512)->generate($reply_link); !!}
            </div>
        </div>

        <div class="row mb-8">
            <div class="row">
                <div class="offset-md-4 col-md-8 content-end text-right">
                    <div class="float-right ml-6 enlarge-img-hover" x-on:mouseover="enlarge = true" x-on:mouseleave="enlarge = false" >
                        {!! QrCode::size(80)->generate($reply_link); !!}
                    </div>
                    
                    <div class="z-30">
                        <p class="font-semibold text-lg">Acesso para responder</p>
                        <p class="text-md text-gray-500 mt-1">Para que outras pessoas possam responder, compartilhe o código QR ao lado ou o link baixo:</p>
                        <a href="{{ $reply_link }}" class="text-xl font-semibold text-blue-400" target="_blank">
                            <span class="d-md-none">Abrir link</span>
                            <span class="d-none d-md-block">{{ $reply_link }}</span>

                           
                           
                        </a>
                    </div>
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