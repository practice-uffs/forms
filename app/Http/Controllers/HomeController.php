<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // get all forms from the current user orderded by id desc
        $forms = auth()->user()->forms()->orderBy('id', 'desc')->get();

        foreach($forms as $form){
            if($form->user_questions == '' && $form->title == ''){
                return redirect(route('form.delete', [$form, $form->hash]));
            }

            if($form->user_questions <> '' && $form->title == ''){
                $form->title = 'Formulário '.$form->id;
                $form->save();
            }
        }

        if ($forms == null) {
            $forms = [];
        }

        return view('home', [
            'forms' => $forms
        ]);
    }
}
