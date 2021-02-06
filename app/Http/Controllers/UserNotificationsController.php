<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Mark a specific notification as read.
     *
     * @param \App\User $user
     * @param int $notificationId
     */

    public function destroy(User $user, $notificationId)
    {
        $user->notifications()->find($notificationId)->markAsRead();
    }
}
