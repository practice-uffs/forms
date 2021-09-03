<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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

        return view('reply.create', [
            'form' => $form,
        ]);
    }
}
