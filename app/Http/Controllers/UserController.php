<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(): View
    {
        return view('users.edit');
    }
}
