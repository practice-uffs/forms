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
            ],            
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
}
