<?php

namespace App\Http\Controllers;

use App\LastLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LastLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sessions.index', ['logins' => LastLogin::all()]);
    }
}
