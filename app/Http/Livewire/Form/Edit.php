<?php

namespace App\Http\Livewire\Form;

use CCUFFS\Text\PollFromText;
use Illuminate\Database\Eloquent\Model;

class Edit extends \App\Http\Livewire\Crud\Main
{
    public $poll_view = '';

    public function mount($model = '', $edit = null)
    {
        parent::mount($model, $edit);
        $this->renderUserQuestion($this->data['user_questions']);
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
        if (empty($data['questions'])) {
            return $data;
        }

        // Colocamos no campo de visualização do questionário o "render"
        // do texto de perguntas do usuário.
        $this->poll_view = '';

        return $data;
    }

    /**
     * @param array $values
     * 
     * @return [type]
     */
    protected function prepareValuesForCreate(array $values) {
        $result = parent::prepareValuesForCreate($values);
        $result['questions'] = PollFromText::make($values['user_questions']);

        return $result;
    }

    /**
     * @param array $values
     * @param Model $item
     * 
     * @return [type]
     */
    protected function prepareValuesForUpdate(array $values, Model $item) {
        $result = parent::prepareValuesForUpdate($values, $item);
        $result['questions'] = PollFromText::make($values['user_questions']);

        return $result;
    }

    public function resetAfterUpdate()
    {
        // não faz nada...
    }

    protected function renderUserQuestion($value)
    {
        if (empty($value)) {
            return;
        }

        // TODO: colocar um pouco de carinho aqui quando PollFromText::makeHtml() existir :D
        $poll = PollFromText::make($value);
        $this->poll_view = '';

        foreach($poll as $question) {
            $type = $question['type'];
            $this->poll_view .= $question['text'] . '<br />';
            switch($question['type']) {
                case 'input': $this->poll_view .= '<input type="'.$type.'">'; break;
                case 'select':
                    $this->poll_view .= '<select>';
                    foreach($question['options'] as $value) { $this->poll_view .= "<option>$value</option>";}
                    $this->poll_view .= '</select>';
                    break;
            }
            $this->poll_view .= '<br />';
        }
    }

    public function updated($field, $value)
    {
        $this->update();
        
        if ($field == 'data.user_questions') {
            $this->renderUserQuestion($value);   
        }
    }
}
