<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $is_edit = ($this->route()->parameter('id')) ? true : false;

        return [
            'name' => 'required|string|max:100',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'description' => 'required|string|max:2000',
            'tag_for_search' => 'required|string|max:1000',
            'img' => ($is_edit) ? 'nullable|image|file' : 'required|image|file',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '商品名',
            'price' => '価格',
            'description' => '説明文',
            'tag_for_search' => '検索用タグ',
            'img' => '画像',
            'stock' => '在庫数'
        ];
    }
}
