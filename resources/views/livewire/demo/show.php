<div>
    <div class="row" x-data="{}">
        <div class="col-1"></div>
        <div class="col-10 pt-2">
            <div class="d-md-flex w-full">
                <div class="w-100 mr-4">
                    <label for="user_questions" class="label mb-4">
                        <span class="text-gray-400 m-auto text-xl font-light">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Descrição das perguntas (edite!)
                        </span>
                    </label>
                    <textarea wire:model="user_questions" name="user_questions" placeholder="Ex.: Qual sua cor favorita?" class="textarea textarea-bordered border-blue-300 h-64 w-full"></textarea>
                </div>
                <div class="w-100">
                    <label class="label mb-4">
                        <span class="text-gray-400 m-auto text-xl font-light">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 13v-1m4 1v-3m4 3V8M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                            Visualização de respondente
                        </span>
                    </label>
                    <div class="mockup-window bg-base-300 h-64 pb-10">
                        <div class="absolute top-3 right-2"></div>
                        <div class="w-full h-64 p-2 bg-gray-100 overflow-scroll">
                            <div x-html="document.getElementById('poll_view').value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>

    <textarea wire:model="poll_view" name="poll_view" id="poll_view" class="hidden"></textarea>
</div>