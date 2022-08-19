<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class ReplyController extends Controller
{
    public function create(Form $form, string $hash)
    {
        if ($form->hash !== $hash) {
            abort(404);
        }

        $user = Auth::user();

        View::share('layout_no_footer', true);
        View::share('layout_header_simplified', true);

        if (!$form->canBeRepliedBy($user)) {
            return view('reply.notallowed');
        }

        //time control
        if($form->timer){
            if($form->time_to_answer){
                $now =  date("Y-m-d H:i:s", strtotime('now')-3600*3);
                $date_time_to_answer =  date("Y-m-d H:i:s", strtotime($form->date_to_answer.$form->time_to_answer));
             
                if($date_time_to_answer < $now){
                    return view('reply.notallowed');
                }
            }else{
                return view('reply.notallowed');
            }    
        }

        return view('reply.create', [
            'form' => $form,
        ]);
    }
}
