<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReplyController extends Controller
{
    public function create(Form $form, string $hash)
    {
        if ($form->hash !== $hash) {
            abort(404);
        }

        return view('reply.create', [
            'form' => $form,
        ]);
    }
}
