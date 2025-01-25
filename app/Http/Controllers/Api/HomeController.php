<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index(){
        $brands = Brand::where('status',1)->get();
        $category = Category::where('status',1)->get();
        $products = Product::where('status',1)->get();
        
        $all_brands = [];
        foreach ($brands as $key => $value) {
            $brand = [];
            $brand['id'] = $value->id;
            $brand['name'] = $value->name;
            $brand['image'] = asset("storage/".$value->image);
            $all_brands[] = $brand; 
        }

        $all_category = [];
        foreach ($category as $key => $value) {
            $category = [];
            $category['id'] = $value->id;
            $category['name'] = $value->name;
            $category['image'] = asset("storage/".$value->image);
            $all_category[] = $category; 
        }
       
        $all_products = [];
        foreach ($products as $key => $value) {
            $product = [];
            $product['id'] = $value->id;
            $product['brand_id'] = ($value->brand_id != '')?$value->brand_id:"";
            $product['brand_name'] = (isset($value->brand->name) && $value->brand->name != '' )? $value->brand->name:"";
            $product['category_name'] = (isset($value->category->name) && $value->category->name != '' )?$value->category->name:"";
            $product['category_id'] = ($value->category_id != '')?$value->category_id:'';
            $product['name'] = $value->name;
            $product['price'] = $value->price;
            $product['minqty'] = $value->minqty;
            $product['maxqty'] = $value->maxqty;
            $product['quantity'] = $value->quantity;
            $product['image'] = asset("storage/".$value->image);
            $all_products[] = $product; 
        }
        $mergedResponse = [
            'message' => 'Data Found',
            'status' => true,
            'data' => [
                'brands' => $all_brands,
                'categories' => $all_category,
                'products' => $all_products
            ]
        ];
        return response()->json($mergedResponse);
    }

    public function create_order(Request $request){
        $user = Auth::user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->total = $request->total;
        $order->payment_method = $request->payment_method;
        $order->status = (string)$request->status;
        $order->save();

        $order_id = $order->id;
        $order_details = [];
        foreach ($request->order_details as $key => $value) {
   
            $order_details[] = [
                'product_id'=>$value['product_id'],
                'quantity'=>$value['quantity'],
                'price' => $value['price'],
                'subtotal' => $value['subtotal'],
                'order_id' => $order_id,
                'created_at'=>now(),
                'updated_at' => now()
            ];
        }
        Order_detail::insert($order_details);

        $mergedResponse = [
            'message' => 'Order Created Successfully !!',
            'status' => true,
            'data' => [
                'order' => [],
            ]
        ];
        return response()->json($mergedResponse);
    }
}
