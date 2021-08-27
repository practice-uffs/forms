<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
}
