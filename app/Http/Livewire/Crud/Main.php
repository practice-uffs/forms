<?php

namespace App\Http\Livewire\Crud;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Model\Form;
use App\Model\User;
use App\Http\Controllers\ReplyController;
use Auth;

/**
 * 
 */
class Main extends Component
{
    use WithFileUploads;

    public static string $modelTypeString = 'model:';
    public static string $modelCrudPropertyName = 'crud';
    public static string $fileUploadBucket = 'crud_uploads';

    public Collection $items;
    public array $data = [];
    public array $fields = []; // see mount()
    public $editing = null;
    public $finished = false;

    public bool $show_create_panel = true;
    public bool $show_list = true;
    public bool $show_success = true;
    public bool $show_action_buttons = true;
    public array $override = [];

    public string $model = ''; // E.g. '\App\Model\Order'
    public string $view_name = 'livewire.crud.main';
    public array $include_create = []; // Fields to include in create operations    
    public array $include_update = []; // Fields to include in update operations

    /**
     * 
     */
    private function applyModelCrudInfoOverride(array & $modelCrudInfo) {
        if (count($this->override) == 0) {
            return;
        }

        $fields = array_keys($modelCrudInfo['fields']);

        foreach($this->override as $field => $props) {
            if (!in_array($field, $fields)) {
                throw new \Exception('Cannot override unknown field [' . $field . '] in model ' . $this->model);
            }

            foreach($props as $key => $value) {
                $path = 'fields.' . $field . '.' . $key;
                Arr::set($modelCrudInfo, $path, $value);
            }
        }
    }

    /**
     * 
     */
    protected function modelCreated(Model $model) {
        
    }

    /**
     * 
     */
    protected function modelUpdated(Model $model) {

    }    

    /**
     * 
     * 
     * @param array $data
     * 
     * @return array
     */
    protected function prepareModelData(array $data) :array
    {
        return $data;
    }

    /**
     * 
     * 
     * @param array $modelCrudInfo
     * 
     * @return array
     */
    protected function prepareModelCrudInfo(array $modelCrudInfo) :array
    {
        $this->applyModelCrudInfoOverride($modelCrudInfo);
        return $modelCrudInfo;
    }

    /**
     * @param array $values
     * 
     * @return [type]
     */
    protected function prepareValuesForCreate(array $values) {
        return array_merge($values, $this->include_create);
    }

    /**
     * @param array $values
     * @param Model $item
     * 
     * @return [type]
     */
    protected function prepareValuesForUpdate(array $values, Model $item) {
        return array_merge($values, $this->include_update);
    }

    protected function modelCrudInfo() :array
    {
        if (empty($this->model)) {
            return [];
        }

        $crudPropertyName = self::$modelCrudPropertyName;
        $modelCrudInfo = $this->model::$$crudPropertyName;

        if (!is_array($modelCrudInfo)) {
            return [];
        }

        return $this->prepareModelCrudInfo($modelCrudInfo);
    }

    protected function fields() :array
    {
        $modelCrudInfo = $this->modelCrudInfo();

        if(isset($modelCrudInfo['fields'])) {
            return $modelCrudInfo['fields'];
        }

        return [];
    }

    public function mount($model = '', $edit = null)
    {
        if (!empty($model)) {
            $this->model = $model;
        }

        $this->fields = $this->createPublicFieldsProperty();

        foreach($this->fields as $index => $field){
            switch($field['type']){
                case 'input':
                    switch($field['question_config']){
                        case 0: $this->fields[$index]['type'] = 'text'; break;
                        case 1: $this->fields[$index]['type'] = 'date'; break;
                        case 2: $this->fields[$index]['type'] = 'time'; break;
                        case 3: $this->fields[$index]['type'] = 'tel'; break;
                        case 4: $this->fields[$index]['type'] = 'email'; break;
                        case 5: $this->fields[$index]['type'] = 'file'; break;
                    }
                    break;
                case 'select':
                    switch($field['question_config']){
                        case 0: $this->fields[$index]['type'] = 'select'; break;
                        case 1: $this->fields[$index]['type'] = 'radio'; break;
                        case 2: $this->fields[$index]['type'] = 'checkbox'; break;
                    }
                    break;
            }
        }

        if ($edit != null) {
            $this->data = $this->prepareModelData($edit->toArray());
        }
    }

    protected function rules()
    {
        $rules = [];

        foreach ($this->fields() as $key => $info) {
            if (isset($info['validation'])) {
                $key = 'data.' . $key;
                $rules[$key] = $info['validation'];
            }
        }

        return $rules;
    }

    protected function makeFieldKey($property) :string
    {
        return 'data.' . $property;
    }

    protected function isModelType($text)
    {
        return stripos($text, self::$modelTypeString) !== false;
    }

    protected function extracModelFromModelType($text)
    {
        $pieces = explode('|', $text);

        if (count($pieces) >= 2) {
            $text = $pieces[0];
        }

        return str_replace(self::$modelTypeString, '', $text);
    }    

    protected function extracValueFieldFromModelType($text)
    {
        $pieces = explode('|', $text);

        if (count($pieces) <= 1) {
            return 'name'; // TODO: make dybamic
        }

        return $pieces[1];
    }    

    protected function fillOptionsForModelType($type)
    {
        $model = $this->extracModelFromModelType($type);
        $idField = 'id'; // TODO: make dynamic?
        $valueField = $this->extracValueFieldFromModelType($type);
       
        $options = $model::all()->map(function($item) use ($idField, $valueField) {
            $key = $item[$idField];
            $value = $item[$valueField];
            return [
                'id' => $key,
                'text' => $value
            ];
        });

        return $options;
    }

    protected function fillOptionsForSelectType(array $info)
    {
        if (!isset($info['options'])) {
            return [];
        }

        $options = [];

        foreach($info['options'] as $key => $value) {
            $options[] = [
                'id' => $key,
                'text' => $value
            ];
        }

        return $options;
    }

    protected function createPublicFieldsProperty()
    {
        if (count($this->fields()) == 0) {
            return [];
        }

        $fields = [];

        foreach($this->fields() as $expectedKey => $info) {
            $key = $this->makeFieldKey($expectedKey);
            $fields[$key] = $info;
            $fields[$key]['property'] = $expectedKey;

            $hasType = isset($info['type']);

            if (!$hasType) {
                continue;
            }

            if ($this->isModelType($info['type'])) {
                $fields[$key]['type'] = 'select';
                $fields[$key]['options'] = $this->fillOptionsForModelType($info['type']);
            }

            if ($info['type'] == 'select' || $info['type'] == 'radio') {
                $fields[$key]['options'] = $this->fillOptionsForSelectType($info);
            }
        }

        return $fields;
    }

    protected function getDataForInsertOrUpdate() {
        $values = collect($this->data)->map(function($item) {
            if(is_a($item, UploadedFile::class)) {
                // This field is a uploaded file. We need to store it
                // in a place and save the path.
                $path = $this->storeUploadedFile($item);
                return $path;
            } else {
                return $item;
            }
        })->toArray(); 


        return $values;
    }

    protected function storeUploadedFile($file) {
        $path = $file->store(self::$fileUploadBucket);
        return $path;
    }

    public function render()
    {
        $this->items = $this->model::all();
        return view($this->view_name);
    }

    public function resetInput()
    {
        array_splice($this->data, 0);
    }

    public function store(Form $form)
    {
        
        //percorre o array procurando checkboxes para concatenar e salvar num único item
        foreach($this->data as $index => $data){
            if(!isset($this->field['data.'.$index])){
                if($data !== false){
                    $index_exploded = explode('#', $index);
                    if(isset($this->data[$index_exploded[0]])){
                        if($this->fields['data.'.$index_exploded[0]]['type'] == 'checkbox'){
                            $this->data[$index_exploded[0]] .= ','.$data;
                            unset($this->data[$index]); //unset do item já concatenado
                        }   
                    }else{
                        $this->data[$index_exploded[0]] = $data;
                        unset($this->data[$index]); //unset do item já concatenado
                    }
                }else{
                    unset($this->data[$index]); //unset de item = false (marca automaticamente ao desselecionar um checkbox)
                }
            }
        }


        $user =  Auth::user();
        if($form->canBeRepliedBy($user)){

            //se houver uso de tempo limite
            if($form->timer){ 
                $now =  date("Y-m-d H:i:s", strtotime('now')-3600*3);
                $date_time_to_answer =  date("Y-m-d H:i:s", strtotime($form->date_to_answer.$form->time_to_answer));
                
                //se o tempo acabou (a submissão foi forçada)
                if($date_time_to_answer <= $now){
    
                    //se houver ao menos uma resposta
                    if(count($this->data)){
                        
                        //preencher as respostas não respondidas em tempo com algum conteúdo para ser validado
                        if(count($this->data) < count($form->questions)){
                            for($i = 0; $i < count($form->questions); $i++){
                                if(!isset($this->data['poll_'.$i]) or $this->data['poll_'.$i] == ''){
                                    $this->data['poll_'.$i] = "Sem resposta";
                                };
                            }                        
                        }
                    }else{
                        return redirect(route('reply.create', ['form' => $form,'hash' => $form->hash]));
                    }
                }
            }

            $this->validate();
            $values = $this->getDataForInsertOrUpdate();
            
            // Remove any defined 'id' to ensure an insert is
            // performed instead of an update 
            unset($values['id']);
    
            $values = $this->prepareValuesForCreate($values);
            $entry = $this->model::create($values);
    
            $this->modelCreated($entry);
            $this->resetInput();
            $this->finished(true);
        }else{
            return redirect(route('reply.create', ['form' => $form,'hash' => $form->hash]));
        }
    }

    public function finished($value, Form $form = null)
    {
        $this->finished = $value;


        //se houver uso de tempo limite
       

        if($form != null and $value == false){

            //check if its avaliable to answer again
            if($form->timer){ 
                $now =  date("Y-m-d H:i:s", strtotime('now')-3600*3);
                $date_time_to_answer =  date("Y-m-d H:i:s", strtotime($form->date_to_answer.$form->time_to_answer));
                
                //se o tempo acabou
                if($date_time_to_answer <= $now){
                    return redirect(route('reply.create', ['form' => $form,'hash' => $form->hash]));
                }
            }

            
            $user =  auth()->user();
            if(!$form->canBeRepliedBy($user)){
                return redirect(route('reply.create', ['form' => $form,'hash' => $form->hash]));
            }
        }
    }

    public function hideInlineEdit()
    {
        $this->editing = null;
    }

    public function showInlineEdit($id)
    {
        $this->editing = $id;
    }

    public function cancel()
    {
        $this->resetInput();
        $this->hideInlineEdit();
    }

    public function edit($id)
    {
        $this->finished(false);
        $this->data = $this->model::findOrFail($id)->toArray();
        $this->data = $this->prepareModelData($this->data);
        $this->showInlineEdit($id);
    }

    public function update($id = '')
    {
        $this->validate();

        $id = empty($id) ? @$this->data['id'] : $id;

        if (!$id) {
            // TODO: fail?
            return;
        }

        $id = $this->data['id'];
        $item = $this->model::findOrFail($id);
        
        $values = $this->getDataForInsertOrUpdate();
        $values = $this->prepareValuesForUpdate($values, $item);
        $item->update($values);

        $this->modelUpdated($item);
        $this->resetAfterUpdate();
    }

    public function resetAfterUpdate()
    {
        $this->resetInput();
        $this->hideInlineEdit();
        $this->finished(true);
    }

    public function destroy($id)
    {
        if (!$id) {
            return;
        }

        $item = $this->model::findOrFail($id);
        $item->delete();        
    }
}
