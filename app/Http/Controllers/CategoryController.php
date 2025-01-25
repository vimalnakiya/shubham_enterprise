<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
    
    }

    public function index(CategoryDataTable $DataTable ){
        $header = 'Categories';
        return $DataTable->render('category.list',compact('header'));
    }

    public function add(Request $request){
    
        $request->validate([
            'name' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);
      
        $image = 'category_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('category/', $image, 'public');
        $image = 'category/'.$image;

        $book = new Category();
        $book->name = $request->name;
        $book->image = $image;
        $book->save();
        
        toastr('Your data has been saved');
        return redirect()->route('categories');
    }

    public function edit(Request $request){
        $books = Category::where('id',$request->id)
            ->get();
        $book = $books[0]; 
        $html = view('category.edit',compact('book'));
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

            $image = 'category_image' . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('category/', $image, 'public');
            $image = 'category/'.$image;

            
            if(isset($request->old_image) && $request->old_image != ''){
                if (Storage::disk('public')->exists($request->old_image)) {
                    Storage::disk('public')->delete($request->old_image);
                }
            }
        }
        Category::where('id',$request->id)
            ->update([
                'name' => $request->name,
                'image' => $image,
            ]);
        toastr('Your data has been saved');
        return redirect()->route('categories');
    }

    public function delete(Request $request){
        $book_image = Category::select('image')
            ->where('id',decrypt($request->id))
            ->get();
        Category::where('id', decrypt($request->id))->delete();
        if (Storage::disk('public')->exists($book_image[0]->image)) {
            Storage::disk('public')->delete($book_image[0]->image);
        }
        toastr('Category deleted successfully !');
        return redirect()->route('categories');
    }
}
