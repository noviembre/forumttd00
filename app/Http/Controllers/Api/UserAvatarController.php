<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{


    public function store(Request $request)
    {

        $request->validate([

            'avatar' => 'required'

        ]);

        auth()->user()->update([
            'avatar_path' => $request->file('avatar')->storeAs('avatars', 'avatar.jpg', 'public')
        ]);
    }
}
