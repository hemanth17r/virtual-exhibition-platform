<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function show(User $creator)
    {
        return view('creator.show', ['user' => $creator]);
    }
}
