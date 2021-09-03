<div>
    <div x-data="{ tab: window.location.hash ? window.location.hash.substring(1) : 'questions' }" id="tab_wrapper">

        <div class="tabs row">
            <a :class="{ 'tab-active': tab === 'questions' }" @click.prevent="tab = 'questions'; window.location.hash = 'questions'" href="#" class="tab tab-lg tab-lifted col-2">Perguntas</a>
            <a :class="{ 'tab-active': tab === 'permissions' }" @click.prevent="tab = 'permissions'; window.location.hash = 'permissions'" href="#" class="tab tab-lg tab-lifted col-2">Permissões</a>
            <a :class="{ 'tab-active': tab === 'replies' }" @click.prevent="tab = 'replies'; window.location.hash = 'replies'" href="#" class="tab tab-lg tab-lifted col-2">Respostas <span id="repliesBadge"></span></a>
            <a href="#" class="tab tab-lg tab-lifted text-white col-6">|</a>
        </div>

        <div x-show="tab === 'questions'" class="row pb-4 pt-4">
            <div class="row mb-2">
                <div class="col-12">
                    <label for="title" class="label">
                        <span class="label-text">Titulo do questionário</span>
                    </label>
                    <input wire:model="form.title" type="text" name="title" placeholder="Ex.: Pesquisa de Satisfação" class="input input-bordered w-full" />
                </div>
            </div>            
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="flex w-full">
                        <div class="w-1/2 mr-4">
                            <label for="user_questions" class="label">
                                <span class="label-text">Descrição das perguntas</span>
                            </label>
                            <textarea wire:model="form.user_questions" name="user_questions" placeholder="Ex.: Qual sua cor favorita?" class="textarea textarea-bordered h-screen w-full"></textarea>
                        </div>
                        <div class="w-1/2">
                            <label class="label">
                                <span class="label-text">Visualização de respondente</span>
                            </label>
                            <div class="mockup-window bg-base-300 h-screen">
                                <div class="absolute top-3 right-2">kjh</div>
                                <div class="w-full h-full p-2 bg-gray-100 overflow-scroll">
                                    <div x-html="$refs.poll_view.value"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <textarea wire:model="poll_view" name="poll_view" x-ref="poll_view" class="hidden"></textarea>
        
        <div x-show="tab === 'permissions'" class="row p-2">
            <div class="row">
                <div class="col-6 p-4">
                    <label class="cursor-pointer label flex">
                        <span class="label-text">
                            Aceitando respostas<br />
                            <span class="text-gray-400">Controla se este questionário está recebendo (ou não) respostas.</span>
                        </span> 
                        <div>
                            <input wire:model="form.is_accepting_replies" type="checkbox" class="toggle toggle-primary"> 
                            <span class="toggle-mark"></span>
                        </div>
                    </label>                
                </div>

                <div class="col-6 p-4">
                    <label class="cursor-pointer label flex">
                        <span class="label-text">
                            Exigir autenticação para responder<br />
                            <span class="text-gray-400">Respondentes precisam efetuar login no Practice Forms para conseguir responder.</span>
                        </span> 
                        <div>
                            <input wire:model="form.is_auth_required" type="checkbox" class="toggle toggle-primary"> 
                            <span class="toggle-mark"></span>
                        </div>
                    </label>                
                </div>

                <div class="col-6 p-4">
                    <label class="cursor-pointer label flex">
                        <span class="label-text">
                            Respostas únicas<br />
                            <span class="text-gray-400">
                                Cada respondente pode responder às questões uma única vez (não permite que um mesmo usuário responda o mesmo questionário várias vezes, por exemplo).
                                <p class="text-xs text-gray-500 mt-2"><strong>OBS:</strong> ao utilizar esse recurso, você obrigará seus respondentes a se autenticarem no Practice Form.</p>
                            </span>
                        </span> 
                        <div>
                            <input wire:model="form.is_one_reply_only" type="checkbox" class="toggle toggle-primary"> 
                            <span class="toggle-mark"></span>
                        </div>
                    </label>                
                </div>
            </div>
        </div>
        
        <div x-show="tab === 'replies'" class="row p-2 pt-4" id="replies">
            <div class="row">
                <div class="col-12 no-replies-yet"></div>
            </div>
        </div>
    </div>
</div>