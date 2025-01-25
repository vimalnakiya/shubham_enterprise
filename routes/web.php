<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Carbon\Carbon;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $users = User::select('id')
        ->where('role_id','!=',1)
        ->count();
    $brands = Brand::count();
    $categories = Category::count();
    $products = Product::count();
    $orders = Order::count();
    $recently_added = User::select('id', 'name','email', DB::raw('created_at, created_at as created_at_human'))
        ->where('role_id', '!=', 1)
        ->orderBy('id', 'DESC')
        ->limit(6)
        ->get()
        ->map(function ($user) {
            $user->created_at_human = Carbon::parse($user->created_at)->diffForHumans();
            return $user;
        });
        $monthwise_array = [];
        $monthlyData = User::select(DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) as total_user'))
            ->whereYear(DB::raw('created_at'), date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->where('role_id','!=',1)
            ->get();
        if($monthlyData){
            foreach($monthlyData as $temp){
                $monthwise_array[$temp->month] = $temp;
            }
        }
        $monthwise_array_order = [];
        $monthlyData = Order::select(DB::raw('MONTH(created_at) AS month'), DB::raw('COUNT(id) as total_user'))
            ->whereYear(DB::raw('created_at'), date('Y'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        if($monthlyData){
            foreach($monthlyData as $temp){
                $monthwise_array_order[$temp->month] = $temp;
            }
        }
   
    $header = 'Dashboard';

    return view('dashboard',compact('users','header','recently_added','brands','categories','products','orders','monthwise_array','monthwise_array_order'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('/brands',[BrandController::class,'index'])->name('brands');
    Route::post('/brands/add',[BrandController::class,'add'])->name('brands.add');
    Route::post('/brands/edit',[BrandController::class,'edit'])->name('brands.edit');
    Route::post('/brands/update',[BrandController::class,'update'])->name('brands.update');
    Route::get('/brands/delete',[BrandController::class,'delete'])->name('brands.delete');
});

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('/categories',[CategoryController::class,'index'])->name('categories');
    Route::post('/categories/add',[CategoryController::class,'add'])->name('categories.add');
    Route::post('/categories/edit',[CategoryController::class,'edit'])->name('categories.edit');
    Route::post('/categories/update',[CategoryController::class,'update'])->name('categories.update');
    Route::get('/categories/delete',[CategoryController::class,'delete'])->name('categories.delete');
});

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('/products',[ProductController::class,'index'])->name('products');
    Route::post('/products/add',[ProductController::class,'add'])->name('products.add');
    Route::post('/products/edit',[ProductController::class,'edit'])->name('products.edit');
    Route::post('/products/save_stock',[ProductController::class,'save_stock'])->name('products.save_stock');
    Route::post('/products/get_stock',[ProductController::class,'get_stock'])->name('products.get_stock');
    Route::post('/products/update',[ProductController::class,'update'])->name('products.update');
    Route::get('/products/delete',[ProductController::class,'delete'])->name('products.delete');
});

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('/users',[UsersController::class,'index'])->name('users');
    Route::get('/users/verify',[UsersController::class,'verify'])->name('users.verify');
});

Route::middleware(['web','auth','verified'])->group(function () {
    Route::get('/orders',[OrdersController::class,'index'])->name('orders');
    Route::get('/orders/view',[OrdersController::class,'view'])->name('orders.view');
});

require __DIR__.'/auth.php';
