<?php

namespace App\Http\Livewire;

use App\Models\messages;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactComponent extends Component
{
    public function render()
    {
        
        $user_id = Auth::user()->id;
        $messages = messages::where('user_id',$user_id)->get();

        return view('livewire.contact-component', ['messages' => $messages]);
    }
}
