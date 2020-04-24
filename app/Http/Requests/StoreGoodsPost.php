<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreGoodsPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //获取路由别名
        $name = \Route::currentRouteName();
        if($name=='goodsstore'){
            //添加
            return [
                'goods_name'=>'regex:/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_]{2,50}$/u|unique:goods',
                'cate_id'=>'required',
                'brand_id'=>'required',
                'goods_num'=>'required|integer|max:99999999',
                'goods_price'=>'required',
            ];
        }
        
        if($name=='goodsupdate'){
            //编辑
            return [
                'goods_name'=>[
                    Rule::unique('goods')->ignore(request()->id,'goods_id'),
                    'regex:/^[\x{4e00}-\x{9fa5}0-9a-zA-Z_ ]{2,50}$/u'
                ],
                'cate_id'=>'required',
                'brand_id'=>'required',
                'goods_num'=>'required|integer|max:99999999',
                'goods_price'=>'required',
            ];
        }
    }

    public function messages(){
        return [
            'goods_name.unique'=>'商品名称已存在！',
            'goods_name.regex'=>'商品名称长度范围为2-50位，规则是可以包含中文、数字、字母、下划线',
            'cate_id.required'=>'请选择商品分类',
            'brand_id.required'=>'请选择商品品牌',
            'goods_num.required'=>'商品库存必填',
            'goods_num.integer'=>'商品库存必须是数字',
            'goods_num.max'=>'商品库存不超过亿，即不超过8位数字',
        ];

    }



}
