<?php
namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopComponent extends Component
{
    use WithPagination;

    public $pageSize = 12;
    public $orderBy = "Default Sorting";
    public $min_value = 0;
    public $max_value = 1000;
    public $searchTerm;

    public function mount(Request $request)
    {
        $this->searchTerm = $request->search;
    }

    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
        session()->flash('success_message', 'Item added to Cart');
        return back();
    }

    public function changePageSize($size)
    {
        $this->pageSize = $size;
    }

    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }

    public function render()
    {
        $query = Product::query();

        if ($this->searchTerm) {
            $query->where('products.name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhereHas('category', function ($q) {
                      $q->where('name', 'like', '%' . $this->searchTerm . '%');
                  });
        }

        if ($this->orderBy == 'Price: Low to High') {
            $query = $query->orderBy('regular_price', 'ASC');
        } elseif ($this->orderBy == 'Price: High to Low') {
            $query = $query->orderBy('regular_price', 'DESC');
        } elseif ($this->orderBy == 'Sort By Newness') {
            $query = $query->orderBy('created_at', 'DESC');
        }

        $products = $query->paginate($this->pageSize);
        $categories = Category::orderBy('name', 'ASC')->get();

        return view('livewire.shop-component', ['products' => $products, 'categories' => $categories]);
    }
}
