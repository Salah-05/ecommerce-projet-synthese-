<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Review; // Corrected the model name to Review (capitalized and singular)
use App\Models\reviews;
use Illuminate\Http\Request; // Corrected the import statement for Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class CommentComponent extends Component
{
    public $pr_id;
    public $message;
    public $stars;

    public function mount($pr_id)
    {
        $this->pr_id = $pr_id;
    }
    public function render()
    {
        $comments = reviews::with('user')->where('product_id', $this->pr_id)->get();; // Corrected the model name to Review
        return view('livewire.comment-component', compact('comments'));
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        reviews::create([
            'message' => $request->input('message'),
            'stars' => $request->input('stars'),
            'user_id' => Auth::id(),
            'product_id' => $request->input('pr_id'),
        ]);

        return redirect()->back()->with('success', 'comment est ajouter avec succès');

    }
}
