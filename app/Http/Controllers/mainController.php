<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mainController extends Controller
{
    public function index(Request $request)
    {
    	$this->validate($request, [
        'email' => 'required|email',
        'type' => 'required',
        'wordsearched' => 'required',
        'prixmax' => 'required',
        'prixmin' => 'required',

    ]);
    }
}
