<?php

namespace App\Http\Livewire\Form;

use App\Model\Form;
use CCUFFS\Text\PollFromText;
use Livewire\Component;

class Edit extends Component
{
    public Form $form;
    public string $poll_view = '';    

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

    public function update()
    {
        $this->validate();
        $this->form->save();
    }

    public function updated($field, $value)
    {
        if ($field == 'form.user_questions') {
            $this->renderUserQuestion($value);   
            $this->form->questions = PollFromText::make($value);
        }

        $this->update();        
    }
}
