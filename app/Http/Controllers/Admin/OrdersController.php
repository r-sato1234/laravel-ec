<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Carbon\Carbon;
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
        $orders = $this->Orders->withTrashed()->orderBy('id', 'desc')->paginate(20);

        if ($orders->count() == 0) {
            session()->flash('error', '注文が存在しません');
        }

        return view('admin.Order.index', [
            'orders' => $orders
        ]);
    }

    /**
     * 詳細
     *
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view($id)
    {
        try {
            $order = $this->Orders->withTrashed()->findOrFail($id);

            return view('admin.Order.view', compact('order'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', '存在しない注文です');
        }

        return redirect(route('admin.orders'));
    }

    /**
     * 注文確定
     *
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function fix($id)
    {
        try {
            $order = $this->Orders->findOrFail($id);
            if (!$order->is_unconfirmed) {
                throw new \Exception('未確認の注文のみ確定可能です');
            }

            $order->fill([
                'status' => Order::STATUS_CONFIRMED,
                'fix_date' => Carbon::now(),
            ]);
            $order->save();

            session()->flash('success', '注文を確定しました');

            return redirect(route('admin.orders'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', '存在しない注文です');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect(route('admin.orders'));
    }

    /**
     * キャンセル
     *
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function cancel($id)
    {
        try {
            $order = $this->Orders->findOrFail($id);
            if (!$order->is_unconfirmed) {
                throw new \Exception('未確認の注文のみキャンセル可能です');
            }

            $order->fill([
                'status' => Order::STATUS_CANCELLED,
                'deleted_at' => Carbon::now(),
            ]);
            $order->save();
            session()->flash('success', '注文をキャンセルしました');

            return redirect(route('admin.orders'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', '存在しない注文です');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect(route('admin.orders'));
    }
}
