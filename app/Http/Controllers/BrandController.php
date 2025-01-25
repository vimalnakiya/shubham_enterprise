<?php

namespace App\Http\Controllers;

use App\DataTables\BrandDataTable;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function __construct()
    {
    
    }

    public function index(BrandDataTable $DataTable ){
        $header = 'Brands';
        return $DataTable->render('brands.list',compact('header'));
    }

    public function add(Request $request){
    
        $request->validate([
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);
      
        $image = 'brand_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('brands/', $image, 'public');
        $image = 'brands/'.$image;

        $book = new Brand();
        $book->name = $request->name;
        $book->image = $image;
        $book->save();
        
        toastr('Your data has been saved');
        return redirect()->route('brands');
    }

    public function edit(Request $request){
        $books = Brand::where('id',$request->id)
            ->get();
        $book = $books[0]; 
        $html = view('brands.edit',compact('book'));
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

            $image = 'brand_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('brands/', $image, 'public');
            $image = 'brands/'.$image;

            
            if(isset($request->old_image) && $request->old_image != ''){
                if (Storage::disk('public')->exists($request->old_image)) {
                    Storage::disk('public')->delete($request->old_image);
                }
            }
        }
        Brand::where('id',$request->id)
            ->update([
                'name' => $request->name,
                'image' => $image,
            ]);
        toastr('Your data has been saved');
        return redirect()->route('brands');
    }

    public function delete(Request $request){
        $book_image = Brand::select('image')
            ->where('id',decrypt($request->id))
            ->get();
        Brand::where('id', decrypt($request->id))->delete();
        if (Storage::disk('public')->exists($book_image[0]->image)) {
            Storage::disk('public')->delete($book_image[0]->image);
        }
        toastr('Brand deleted successfully !');
        return redirect()->route('brands');
    }
}
