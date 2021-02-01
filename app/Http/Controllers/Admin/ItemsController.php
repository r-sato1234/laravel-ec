<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
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

        if ($items->count() == 0) {
            session()->flash('error', '商品が存在しません');
        }

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

        if (!$item) {
            return redirect()->route('admin.items')->with('error', '存在しない商品です');;
        }

        return view('admin.Item.view', [
            'item' => $item
        ]);
    }

    /**
     * 新規登録
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function add(Request $request)
    {
        $item = new Item();
        return view('admin.Item.edit', compact('item'));
    }

    /**
     * 編集
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, $id) {
        $admin = Auth::user();
        $item = $this->Items->findByAdminIdAndId($admin->getAttribute('id'), $id);

        return view('admin.Item.edit', compact('item', 'id'));
    }

    /**
     * 新規登録
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(ItemRequest $request) {
        $admin = Auth::user();
        $this->Items->create([
            'admin_id' => $admin->getAttribute('id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'tag_for_search' => $request->input('tag_for_search'),
            'img' => 'test'
        ]);
        // set_message('商品を追加しました。');
        session()->flash('success', '商品を追加しました');

        return redirect(route('admin.items'));
    }

    /**
     * 編集
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function update(ItemRequest $request, $id) {
        $item = $this->Items->findOrFail($id);
        $item->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'tag_for_search' => $request->input('tag_for_search'),
            // 'img' => 'test'
        ]);
        $item->save();
        // set_message('内容を修正しました。');
        session()->flash('success', '商品を編集しました');

        return redirect(route('admin.items.view', ['id' => $id]));
    }
}
