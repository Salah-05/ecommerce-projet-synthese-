<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesComponent extends Component
{
    public function render()
    {
        $categories = Category::pluck('name');

        // Pass the variable name as a string to compact
        return view('livewire.categories-component', compact('categories'));
    }
}
