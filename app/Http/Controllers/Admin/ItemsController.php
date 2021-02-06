<?php

namespace App\Http\Controllers\Admin;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $items = $this->Items->orderBy('id', 'desc')->paginate(20);

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
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function view($id)
    {
        try {
            $item = $this->Items->findOrFail($id);

            return view('admin.Item.view', compact('item'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', '存在しない商品です');
        }

        return redirect(route('admin.items'));
    }

    /**
     * 新規登録
     *
     * @param Request $request
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
     * @param Request $request
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Request $request, $id) {
        try {
            $item = $this->Items->findOrFail($id);

            if (!$this->Items->isAuthUserItem($id, Auth::user()->getAttribute('id'))) {
                throw new \Exception('編集できない製品です');
            }

            return view('admin.Item.edit', compact('item', 'id'));
        } catch (ModelNotFoundException $e) {
            session()->flash('error', '存在しない商品です');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect(route('admin.items'));
    }

    /**
     * 新規登録
     *
     * @param ItemRequest $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(ItemRequest $request) {
        $admin = Auth::user();
        $file_name = $this->__imgUpdate($request->file('img'), $this->Items->getInsertId());
        $this->Items->create([
            'admin_id' => $admin->getAttribute('id'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'tag_for_search' => $request->input('tag_for_search'),
            'img' => $file_name
        ]);
        // set_message('商品を追加しました。');
        session()->flash('success', '商品を追加しました');

        return redirect(route('admin.items'));
    }

    /**
     * 編集
     *
     * @param ItemRequest $request
     * @param string $id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function update(ItemRequest $request, $id) {
        $item = $this->Items->findOrFail($id);
        $file_name = $this->__imgUpdate($request->file('img'), $id);
        $item->fill([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'tag_for_search' => $request->input('tag_for_search'),
            'img' => $file_name
        ]);
        $item->save();
        // set_message('内容を修正しました。');
        session()->flash('success', '商品を編集しました');

        return redirect(route('admin.items.view', ['id' => $id]));
    }

    /**
     * 画像をアップロードする
     *
     * @param Illuminate\Http\UploadedFile $file
     * @param int $id
     * @return string
     */
    private function __imgUpdate($file, $id) {
        $file_name = '';
        if ($file->isValid()) {
            $file_name = time() . '_' . $file->getClientOriginalName();
            $target_path = public_path('uploads/items/' . $id . '/');
            $file->move($target_path, $file_name);
        }

        return $file_name;
    }
}
