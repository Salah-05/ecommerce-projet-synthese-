<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\Message;
use App\Models\messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function broadcast(Request $request)
    {
        $messageText = $request->get('message');
        $user = Auth::user();

        // Store message in the database
        $message = new messages();
        $message->message = $messageText;
        $message->user_id = $user->id;
        $message->save();

        broadcast(new PusherBroadcast($messageText))->toOthers();

        return view('broadcast', ['message' => $messageText, 'user' => $user]);
    }

    public function receive(Request $request)
    {
        $messageText = $request->get('message');
        $user = Auth::user();

        return view('receive', ['message' => $messageText, 'user' => $user]);
    }
}

