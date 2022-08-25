<div>
    @include('livewire.crud.success')

    @if (!$finished)
        @error('generic_error')
            <div class="alert alert-error">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current">    
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>                      
                    </svg> 
                    <label>{{ $message }}</label>
                </div>
            </div>
        @enderror

        <div class="mb-4 pb-4">
            @php $counter_question = 1; @endphp 
            @foreach ($fields as $key => $field)
                @if (isset($field['show']) && ( ($editing && !Str::contains($field['show'], 'edit')) || (!$editing && !Str::contains($field['show'], 'create'))))
                    @continue
                @endif
                <div class="container-question mb-2 p-4 pb-5 shadow-sm">
                @switch(@$field['type'])

                    @case('boolean')
                        <label class="cursor-pointer label flex">
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }} <br/><span class="text-gray-400">{{ @$field['placeholder'] }}</span></span> 
                            <div>
                                <input wire:model="{{ $key }}" type="checkbox"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ $field['type'] }}')" class="toggle toggle-primary"> 
                                <span class="toggle-mark"></span>
                            </div>
                        </label>
                        @break

                    @case('select')
                        <label class="label">
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                        </label> 
                        <select wire:model="{{ $key }}" onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ $field['type'] }}')" class="select select-bordered w-full @error($key) select-error @enderror">
                            <option value=""> -- selecione --</option> 
                            @foreach ($field['options'] as $info)
                                <option value="{{ $info['id']}}">{{ $info['text']}}</option> 
                            @endforeach
                        </select> 
                        @break

                    @case('radio')
                        <label class="label">
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span> 
                        </label>
                        <div class="mt-2">
                            @foreach ($field['options'] as $info)
                                <label class="cursor-pointer mr-5">
                                    <div class="inline-block">
                                        <input wire:model="{{ $key }}" type="radio" checked="checked"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ $field['type'] }}')" class="radio radio-primary" value="{{ $info['id']}}"> 
                                        <span class="radio-mark mr-1"></span>
                                    </div>
                                    <span class="h6 {{ @$field['style'] }}">{{ $info['text']}}</span> 
                                </label>
                            @endforeach
                        </div>
                        @break
                    
                    @case('checkbox')
                        <label class="label">
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span> 
                        </label>
                        <div class="mt-2">
                            @foreach ($field['options'] as $checkbox_index => $info)
                                <label class="cursor-pointer mr-5">
                                    <div class="inline-block">
                                        <input wire:model="{{ $key }}#{{ $checkbox_index }}"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.checked, '{{ $field['type'] }}')" type="checkbox" checked="checked" class="checkbox checkbox-primary" value="{{ $info['id']}}"> 
                                        <span class="radio-mark mr-1"></span>
                                    </div>
                                    <span class="h6 {{ @$field['style'] }}">{{ $info['text']}}</span> 
                                </label>
                            @endforeach
                        </div>
                        @break

                    
                    @case('date')
                    <label class="label" for="{{ $key }}">
                        <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                    </label>
                    <input wire:model="{{ $key }}" type="date" name="{{ $key }}"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ @$field['type'] }}')" placeholder="{{ @$field['placeholder'] }}" class="input input-bordered @error($key) input-error @enderror max-w-md" />
                    @break

                    
                    @case('time')
                    <label class="label" for="{{ $key }}">
                        <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                    </label>
                    <input wire:model="{{ $key }}" type="time" name="{{ $key }}"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ @$field['type'] }}')" placeholder="{{ @$field['placeholder'] }}" class="input input-bordered @error($key) input-error @enderror max-w-md" />
                        @break
                    
                    
                    @case('email')
                    <label class="label" for="{{ $key }}">
                        <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                    </label>
                    <input wire:model="{{ $key }}" type="email" name="{{ $key }}"  onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ @$field['type'] }}')" placeholder="{{ @$field['placeholder'] }}" class="input input-bordered @error($key) input-error @enderror max-w-md" />
                        @break


                    @case('file')
                        <label class="label">
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span> 
                            <a href="#" class="h4-alt"></a>
                        </label>
                        <div
                            class="float-left w-100"
                            wire:ignore
                            x-data="{pond: null}"
                            x-init="
                                pond = FilePond.create($refs.input);
                                pond.setOptions({
                                    allowMultiple: true,
                                    labelIdle:'{{ @$field['placeholder'] }}',
                                    labelFileProcessingComplete: 'Upload finalizado',
                                    server: {
                                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                                            @this.upload('{{ $key }}', file, load, error, progress);
                                            ProgressBar.fieldChanged('{{ $key }}', 1, '{{ $field['type'] }}');
                                        },
                                        revert: (filename, load) => {
                                            @this.removeUpload('{{ $key }}', filename, load);
                                            ProgressBar.fieldChanged('{{ $key }}',  -1, '{{ $field['type'] }}');
                                        },
                                    },
                                });
                            ">
                            <input type="file" name="{{ $key }}" x-ref="input">
                        </div>
                        @break

                    @case('poll')
                        <div class="flex w-full">
                            <div class="w-1/2 p-2">
                                <label class="label" for="{{ $key }}">
                                    <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                                </label>
                                <textarea wire:model="{{ $key }}" name="{{ $key }}" placeholder="{{ @$field['placeholder'] }}" class="textarea textarea-bordered h-screen w-full @error($key) textarea-error @enderror"></textarea>
                            </div>
                            <div class="w-1/2 p-2">
                                <label class="label">
                                    <span class="h4">Visualização</span>
                                </label>
                                <div class="mockup-window bg-base-300">
                                    <div class="absolute top-3 right-2">kjh</div>
                                    <div x-data="{ content: null }" x-init="{ content: @entangle('data.poll') }" class="w-full h-screen p-2 bg-gray-100 overflow-scroll">
                                        <div x-on:blur="content = $event.target.innerHTML">
                                            {!! $poll_view !!}
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        @break

                    @case('textarea')
                        <label class="label" for="{{ $key }}" >
                            <span class="h4">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                        </label>
                        <textarea wire:model="{{ $key }}" name="{{ $key }}" onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ $field['type'] }}')" placeholder="{{ @$field['placeholder'] }}" class="textarea textarea-bordered h-48 mb-2 @error($key) textarea-error @enderror"></textarea>
                        @break

                    @default
                        <label class="label" for="{{ $key }}">
                            <span class="h4 h3">{{ $counter_question++ . '. ' . $field['label'] }}</span>
                        </label>
                        <input wire:model="{{ $key }}" onChange="ProgressBar.fieldChanged('{{ $key }}', this.value, '{{ $field['type'] }}')" type="text" name="{{ $key }}" placeholder="{{ @$field['placeholder'] }}" class="input input-bordered @error($key) input-error @enderror w-full" />
                        @break

                @endswitch

                
                @error($key)
                    <div class="w-100">
                        <span class="h4-alt text-red-500">{{preg_replace('/data.poll [0-9]{1,}/', "'{$field['text']}'", $message)}}</span>
                    </div>
                @enderror

                </div>
            @endforeach
        </div>

        @if ($show_action_buttons)
            @if (isset($data['id']) || $editing)
                <button wire:click="update()" class="btn btn-primary float-right">Salvar</button>
                @if (!isset($edit))
                    <button wire:click="cancel()" class="btn float-right mr-6">Cancelar</button>
                @endif
            @else
                <div class="mt-2 w-100 float-left">
                    <button wire:click="store({{$form->id}})" class="btn btn-wide btn-success ml-auto mr-auto d-flex" id="btn-store">Enviar</button>
                </div>
            @endif
        @endif
    @endif
</div>