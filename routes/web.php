<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\ShopComponent;
use App\Http\Livewire\DetailsComponent;
use App\Http\Livewire\CartComponent;
use App\Http\Livewire\CheckoutComponent;
use App\Http\Livewire\Admin\AdminDashboardComponent;
use App\Http\Livewire\User\UserDashboardComponent;
use App\Http\Livewire\CategoryComponent;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\SearchComponent;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',HomeComponent::class)->name('home.index');

Route::get('/shop',ShopComponent::class)->name('shop');

Route::get('/product/{slug}',DetailsComponent::class)->name('product.details');

Route::get('/cart',CartComponent::class)->name('shop.cart');

Route::get('/checkout',CheckoutComponent::class)->name('shop.checkout');

Route::get('/product-category/{slug}',CategoryComponent::class)->name('product.category');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/contact', \App\Http\Livewire\ContactComponent::class)->name('contact');
    Route::post('/broadcast', [ContactController::class, 'broadcast']);
    Route::post('/receive', [ContactController::class, 'receive']);
});
Route::middleware('auth')->group(function () {
    Route::get('/reviews', \App\Http\Livewire\CommentComponent::class)->name('contact');
    Route::post('/broadcast1', [commentController::class, 'broadcast']);
    Route::post('/receive1', [commentController::class, 'receive']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/user/dashboard',UserDashboardComponent::class)->name('user.dashboard');
});

Route::middleware(['auth','authadmin'])->group(function(){
    Route::get('/admin/dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
});
Route::get('/fetch-suggestions', [SearchComponent::class, 'fetchSuggestions']);

Route::post('/set-language', function () {
    $language = request('language');
    if (in_array($language, ['en', 'fr', 'ar'])) {
        Session::put('locale', $language);
    }
    return redirect()->back();
})->name('setLanguage');

require __DIR__.'/auth.php';
