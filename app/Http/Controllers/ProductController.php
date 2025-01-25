<?php

namespace App\Http\Controllers;

use App\DataTables\ProductDataTable;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
    
    }

    public function index(ProductDataTable $DataTable ){
        $header = 'Products';
        $brands = Brand::where('status',1)->get();
        $categories = Category::where('status',1)->get();
        return $DataTable->render('products.list',compact('header','categories','brands'));
    }

    public function add(Request $request){
    
        $request->validate([
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);
      
        $image = 'product_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('products/', $image, 'public');
        $image = 'products/'.$image;

        $book = new Product();
        $book->name = $request->name;
        $book->brand_id = $request->brand_id;
        $book->category_id = $request->category_id;
        $book->price = $request->price;
        $book->image = $image;
        $book->save();
        
        toastr('Your data has been saved');
        return redirect()->route('products');
    }

    public function edit(Request $request){
        $books = Product::where('id',$request->id)
            ->get();
        $book = $books[0]; 
        $brands = Brand::where('status',1)->get();
        $categories = Category::where('status',1)->get();
        $html = view('products.edit',compact('book','brands','categories'));
        echo $html;
    }

    public function update(Request $request){
        $request->validate([
            'name' => ['required', 'string'],
        ]);
        $image = $request->old_image;
        if ($request->file('image')) {
           
            $request->validate([
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            ]);

            $image = 'product_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('products/', $image, 'public');
            $image = 'products/'.$image;

            
            if(isset($request->old_image) && $request->old_image != ''){
                if (Storage::disk('public')->exists($request->old_image)) {
                    Storage::disk('public')->delete($request->old_image);
                }
            }
        }
        Product::where('id',$request->id)
        ->update([
                'name' => $request->name,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'image' => $image,
            ]);
        toastr('Your data has been saved');
        return redirect()->route('products');
    }

    public function delete(Request $request){
        $book_image = Product::select('image')
            ->where('id',decrypt($request->id))
            ->get();
        Product::where('id', decrypt($request->id))->delete();
        if (Storage::disk('public')->exists($book_image[0]->image)) {
            Storage::disk('public')->delete($book_image[0]->image);
        }
        toastr('Product deleted successfully !');
        return redirect()->route('products');
    }

    public function save_stock(Request $request){
        $product_id = decrypt($request->id);
        $current_quantity = $request->current_quantity;
        $new_quantity = $request->new_quantity;
        $quantity = $current_quantity + $new_quantity;
        Product::where('id',$product_id)->update(['quantity' => $quantity]);
        return true;
    }

    public function get_stock(Request $request){
        $product = Product::where('id',decrypt($request->id))->first();
        return $product;
    }
}
