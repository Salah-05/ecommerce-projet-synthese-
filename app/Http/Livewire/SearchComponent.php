<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class SearchComponent extends Component
{
    public $query;

    public function search()
    {
        return redirect()->route('shop', ['search' => $this->query]);
    }

    public function render()
    {
        return view('livewire.search-component');
    }
    public function fetchSuggestions()
    {
        $products = Product::pluck('name')->toArray();
    
        $categories = Category::pluck('name')->toArray();
    
        $suggestions = array_merge($products, $categories);
    
        return response()->json($suggestions);
    }
    
}
