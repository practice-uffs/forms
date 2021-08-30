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

        $replies = [];
        
        $form->replies()->chunk(100, function ($chunk) use (&$replies) {
            foreach($chunk as $entry) {
                foreach($entry->data as $reply) {
                    $text = $reply['text'];
                    $answer = $reply['answer'];

                    if (!isset($replies[$text])) {
                        $replies[$text] = [];
                    }

                    if (!isset($reply['options'])) {
                        $replies[$text][] = $answer;
                        continue;
                    }

                    $answerLabel = $reply['options'][$answer];

                    if (!isset($replies[$text][$answerLabel])) {
                        $replies[$text][$answerLabel] = 0;
                    }

                    $replies[$text][$answerLabel]++;
                }
            }
        });

        $quesitons = [];

        collect($form->questions)->each(function ($question) use (&$quesitons) {
            $text = $question['text'];
            $quesitons[$text] = $question;
        });

        return response()->json([
            'replies' => $replies,
            'questions' => $quesitons,
        ], 200, [], JSON_NUMERIC_CHECK);
    }    
}
