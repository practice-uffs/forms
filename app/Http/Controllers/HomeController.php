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
        $forms = auth()->user()->forms;

        if ($forms == null) {
            $forms = [];
        }

        return view('home', [
            'forms' => $forms
        ]);
    }
}
