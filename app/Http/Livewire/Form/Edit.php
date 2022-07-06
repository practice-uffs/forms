<?php

namespace App\Http\Livewire\Form;

use App\Model\Form;
use CCUFFS\Text\PollFromText;
use Livewire\Component;
use App\Events\FormUpdated;

class Edit extends Component
{
    public Form $form;
    public string $poll_view = '';
    public $question_config = 0;

    public $rules = [
        'form.title' => 'present',
        'form.user_questions' => 'present',
        'form.is_accepting_replies' => 'present',
        'form.is_auth_required' => 'present',
        'form.is_one_reply_only' => 'present'
    ];


    public function mount(Form $form)
    {
        $this->form = $form;
        $this->renderUserQuestion($this->form->user_questions);
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
            $this->poll_view .= $question['text'] . '<br>';
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

    public function update()
    {
        $this->validate();
        $this->form->save();
        event(new FormUpdated($this->form->id));
    }

    public function updated($field, $value)
    {

        if ($field == 'form.user_questions') {
            $this->renderUserQuestion($value);

            $backup_questions = $this->form->questions;
            $this->form->questions = PollFromText::make($value);
      
            foreach($this->form->questions as $index => $form_question){
                $this->form->questions[$index]['question_config'] = '0';
                $this->rules["question_config"] = 'present';
            }

            foreach($this->form->questions as $index => $form_question){
                foreach($backup_questions as $backup_question){
                    if($this->form->questions[$index]['text'] == $backup_question['text']){
                        $this->form->questions[$index]['question_config']= $backup_question['question_config'];
                    }
                }
            }
            $this->form->save();            
        }

        if ($field == 'form.is_one_reply_only' && $value == true) {
            $this->form->is_auth_required = true;
        }

        if($field == "question_config"){
            $update_config = explode(',', $value);
            $this->form->questions[$update_config[0]]['question_config'] = $update_config[1];
            $this->form->save();
        }

        $this->update();
    }

}
