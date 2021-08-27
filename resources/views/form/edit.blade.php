@extends('layouts.base')
@section('content')

<section>
    <div class="container">
        <header class="section-header">
        </header>

        <div class="row mb-8">
            <div class="row mb-3">
                <div class="col-12">
                    <p class="font-semibold text-md">Acesso para responder</p>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <img src="{{ asset('img/qrcode.svg') }}" class="w-24 float-left mr-2" title="">
                    <p class="text-md text-gray-500 mt-3">Para que outras pessoas possam responder, compartilhe o código QR ao lado ou o link baixo:</p>
                    <a href="#" class="text-2xl font-semibold text-blue-400">{{ config('app.url') }}</a>
                </div>
                <div class="col-4">
                    
                </div>
            </div>
        </div>
        

        <div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'structure' }" id="tab_wrapper">
            <div class="row">
                <div class="col-12">
                </div>
            </div>

            <!-- The tabs navigation -->
            <div class="tabs row">
                <div class="col-12">
                    <a :class="{ 'tab-active': tab === 'structure' }" @click.prevent="tab = 'structure'; window.location.hash = 'structure'" href="#" class="tab tab-lg tab-lifted">Estrutura</a>
                    <a :class="{ 'tab-active': tab === 'replies' }" @click.prevent="tab = 'replies'; window.location.hash = 'replies'" href="#" class="tab tab-lg tab-lifted">Respostas</a>
                    <a href="#" class="tab tab-lg tab-lifted w-4/5 text-white">|</a>
                </div>
            </div>

            <!-- The tabs content -->
            <div x-show="tab === 'structure'" class="row">
                <div class="row">
                    <div class="col-12">
                        @livewire('form.edit', [
                            'model' => 'App\Model\Form',
                            'edit' => $form,
                            'show_list' => false,
                            'show_action_buttons' => false,
                            'include_create' => [
                                'user_id' => auth()->id(),
                            ]
                        ])
                    </div>
                </div>
                
            </div>
            
            <div x-show="tab === 'replies'" class="row">
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection