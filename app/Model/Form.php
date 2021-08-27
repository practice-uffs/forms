<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    const OPEN = 1;

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
     * Meta information about Livewire crud crud
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
