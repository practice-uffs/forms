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


    public function report(Form $form)
    {
        $form_replies = $form->replies()->get();
        $columns = array('Pergunta', 'Tipo', 'Resposta');

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=respostas_formulario_$form->id.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($form_replies, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($form_replies as $reply) {
                $data = $reply->data;
                foreach ($data as $question_reply){
                    $row['Pergunta'] = json_encode($question_reply['text']);
                    $row['Tipo'] = json_encode($question_reply['type']);
                    $row['Resposta'] = json_encode($question_reply['answer']);
                    fputcsv($file, array($row['Pergunta'], $row['Tipo'], $row['Resposta']));
                }
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
    
}
