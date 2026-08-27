<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * トップページを表示する。
     */
    public function index(): View
    {
        return view('welcome');
    }
}
