<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{

    /**
     * Confirm a user's email address.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            User::where('confirmation_token', request('token'))
                ->firstOrFail()
                ->confirm();
        } catch (\Exception $e) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown Token.');
        }
        return redirect(route('threads'))
            ->with('flash', 'Your account is now confirmed! you may post to the forum.');
    }
}
