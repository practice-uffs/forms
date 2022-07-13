<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    /**
     * Eager load the following always
     */
    protected $with = [
        'user',
        'replies.user'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'is_accepting_replies',
        'is_auth_required',
        'is_one_reply_only',
        'title',
        'user_questions',
        'questions',
        'hash',
        'status',
    ];

    //mapeamento dos tipos de respostas
    public $answer_types = [
        'input' => [
            0 => 'text',
            1 => 'date',
            2 => 'time',
            3 => 'tel',
            4 => 'email',
            5 => 'file'
        ],
        'select' => [
           0 => 'select',
           1 => 'radio',
           2 => 'checkbox',
           3 => 'custom'
        ]
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'questions' => AsArrayObject::class,
        'created_at' => 'datetime:d/m/Y',
        'updated_at' => 'datetime:h-i d/m/Y',
    ];

    /**
     * Meta information about Livewire crud
     *
     * @var array
     */
    public static $crud = [
        'fields' => [
            'title' => [
                'label' => 'Título',
                'placeholder' => 'Ex.: Pesquisa de satisfação',
                'validation' => 'present',
            ],
            'is_accepting_replies' => [
                'label' => 'Aceitando respostas',
                'type' => 'boolean',
                'placeholder' => 'Ex.: Pesquisa de satisfação',
                'validation' => 'present',
            ],            
            'is_auth_required' => [
                'label' => 'Exige autenticação para responder',
                'type' => 'boolean',
                'placeholder' => 'Ex.: Pesquisa de satisfação',
                'validation' => 'present',
            ],
            'is_one_reply_only' => [
                'label' => 'Somente uma resposta por usuário (obriga autenticação)',
                'type' => 'boolean',
                'placeholder' => 'Ex.: Pesquisa de satisfação',
                'validation' => 'present',
            ],            
            'user_questions' => [
                'label' => 'Perguntas',
                'type' => 'poll',
                'show' => 'create,edit',
            ]        
        ]
    ];

    /**
     * Get all of the form's replies.
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Get the user associated with the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canBeRepliedBy(User $user = null)
    {
        if ($this->is_auth_required && $user == null) {
            return false;
        }

        if ($this->is_one_reply_only && $this->replies()->where('user_id', $user->id)->exists()) {
            return false;
        }

        return true;
    }

    public function getResultAttribute()
    {
        $replies = [];
        
        $this->replies()->chunk(100, function ($chunk) use (&$replies) {
            foreach($chunk as $entry) {
                foreach($entry->data as $reply) {
                    $text = $reply['text'];
                    $answer = $reply['answer'];
                    $type = $reply['type'];

                    if (!isset($replies[$text])) {
                        $replies[$text] = [];
                    }

                    if (!isset($replies[$text]['type'])) {
                        $replies[$text]['type'] = $type;
                    }

                    if (!isset($reply['options'])) {
                        $replies[$text][] = $answer;
                        continue;
                    }

                    //tratamento para checkbox, a resposta deixa de ser concatenada para facilitar a exibição no relatório
                    if ($reply['question_config'] == 2) {
                        $answer_exploded = explode(',', $answer);
                        if(count($answer_exploded) > 1){
                            foreach($answer_exploded as $new_answer){

                                $answerLabel = $reply['options'][$new_answer];
                                if (!isset($replies[$text][$answerLabel])) {
                                    $replies[$text][$answerLabel] = 0;
                                }
                                $replies[$text][$answerLabel]++;

                            }
                        }else{
                            $answerLabel = $reply['options'][$answer];
                            if (!isset($replies[$text][$answerLabel])) {
                                $replies[$text][$answerLabel] = 0;
                            }
                            $replies[$text][$answerLabel]++;
                        }
                    }else{
                        $answerLabel = $reply['options'][$answer];
                        if (!isset($replies[$text][$answerLabel])) {
                            $replies[$text][$answerLabel] = 0;
                        }
                        $replies[$text][$answerLabel]++;
                    }
                }
            }
        });

        $quesitons = [];

        collect($this->questions)->each(function ($question) use (&$quesitons) {
            $text = $question['text'];
            $quesitons[$text] = $question;
        });

        return [
            'replies' => $replies,
            'questions' => $quesitons,
            'stats' => [
                'repliesCount' => $this->replies()->count(),
            ]
        ];
    }
}
