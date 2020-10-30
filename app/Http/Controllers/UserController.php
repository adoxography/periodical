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
        if (!$user->can('have bio')) {
            abort(404);
        }

        return view('users.show', compact('user'));
    }

    public function edit(): View
    {
        return view('users.edit');
    }
}
