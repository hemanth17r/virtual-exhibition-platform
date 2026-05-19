<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function show(User $user)
    {
        return view('creator.show', compact('user'));
    }
}
