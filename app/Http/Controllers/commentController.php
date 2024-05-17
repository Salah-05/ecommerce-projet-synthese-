<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class commentController extends Controller
{
    public function broadcast(Request $request)
    {
        $reviewsText = $request->get('reviews');
        $user = Auth::user();

        $reviews = new reviews();
        $reviews->reviews = $reviewsText;
        $reviews->user_id = $user->id;
        $reviews->save();

        broadcast(new PusherBroadcast($reviewsText))->toOthers();

        return view('broadcast', ['reviews' => $reviewsText, 'user' => $user]);
    }

    public function receive(Request $request)
    {
        $reviewsText = $request->get('reviews');
        $user = Auth::user();

        return view('receive', ['reviews' => $reviewsText, 'user' => $user]);
    }
}

