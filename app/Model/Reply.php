<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reply extends Model
{
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'form_id',
        'data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => AsArrayObject::class
    ];

    /**
     * Meta information about Livewire crud
     *
     * @var array
     */
    public static $crud = [
        'fields' => []           
    ];

    /**
     * Get the ower of this comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the form of this reply
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }    
}
