<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = User::find($request->user_id);

        Mail::raw($request->message, function ($message) use ($user, $request) {
            $message->to($user->email)
                ->subject($request->subject);
        });

        return redirect()->route('admin.notifications.create')->with('status', 'お知らせメールが送信されました');
    }
}
