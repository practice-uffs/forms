<?php

namespace App\Http\Livewire\Demo;

use CCUFFS\Text\PollFromText;
use Livewire\Component;

class Show extends Component
{
    public string $poll_view = '';    
    public string $user_questions = '';    

    public $rules = [
        
    ];

    public function mount()
    {
        $this->user_questions = "Qual seu nome?\n\nQual sua cor favorita?\n- Azul\n- Amarelo\n- Preto";
        $this->renderUserQuestion($this->user_questions);
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
        if ($field == 'user_questions') {
            $this->renderUserQuestion($value);   
        }
    }
}
