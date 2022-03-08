<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\HomeController;

class FormController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('form.index');
    }

    public function create()
    {
        $form = Form::create([
            'title' => '',
            'user_questions' => '',
            'questions' => [],
            'user_id' => Auth::user()->id,
            'hash' => Str::random(32),
        ]);
        
        $form->save();

        return redirect(route('form.edit', $form));
    }

    public function edit(Form $form)
    {
        return view('form.edit', [
            'form' => $form,
            'reply_link' => route('reply.create', [
                'form' => $form,
                'hash' => $form->hash
            ]),
            'result_json_url' => route('form.result', [
                'form' => $form,
                'hash' => $form->hash
            ]),            
        ]);
    }

    public function interact(Form $form, string $hash)
    {
        if ($form->hash !== $hash) {
            abort(404);
        }

        return view('form.interact', [
            'form' => $form,
        ]);
    }

    public function result(Form $form, string $hash)
    {
        if ($form->hash !== $hash) {
            abort(404);
        }

        return response()->json($form->result, 200, [], JSON_NUMERIC_CHECK);
    }  
    
    public function delete(Form $form, string $hash)
    {
        if ($form->hash !== $hash) {
            abort(404);
        }

        if($form->replies->count()){
            $form->replies()->delete();
        }
        
        $form->delete();

        return redirect(route('home'));
        
    }
    
}
