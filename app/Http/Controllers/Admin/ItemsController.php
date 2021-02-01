<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 商品管理
 */
class ItemsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->Items = new Item();
    }

    /**
     * 一覧
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $admin = Auth::user();
        $items = $this->Items->findByAdminId($admin->getAttribute('id'))->paginate(20);

        return view('admin.Item.index', [
            'items' => $items
        ]);
    }

    /**
     * 詳細
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view($id)
    {
        $admin = Auth::user();
        $item = $this->Items->findByAdminIdAndId($admin->getAttribute('id'), $id);

        return view('admin.Item.view', [
            'item' => $item
        ]);
    }
}
