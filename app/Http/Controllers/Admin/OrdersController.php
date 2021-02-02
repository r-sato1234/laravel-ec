<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * 商品管理
 */
class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->Orders = new Order();
    }

    /**
     * 一覧
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $orders = $this->Orders->orderBy('id', 'desc')->paginate(20);

        if ($orders->count() == 0) {
            session()->flash('error', '注文が存在しません');
        }

        return view('admin.Order.index', [
            'orders' => $orders
        ]);
    }
}
