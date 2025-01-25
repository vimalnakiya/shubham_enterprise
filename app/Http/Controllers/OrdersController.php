<?php

namespace App\Http\Controllers;

use App\DataTables\Order_detailDataTable;
use App\DataTables\OrderDataTable;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(OrderDataTable $DataTable ){
        $header = 'Orders';
        return $DataTable->render('orders.list',compact('header'));
    }

    public function view(Request $request,Order_detailDataTable $DataTable){
        $header = 'Order Details';
        return $DataTable->render('orders.details',compact('header'));
    }
}
