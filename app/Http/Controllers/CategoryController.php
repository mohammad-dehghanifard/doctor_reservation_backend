<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // ایجاد دسته بندی جدید
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                "title" => "required"
            ],
            [
                "title.required" => "لطفا یک عنوان وارد کنید"
            ]
        );

        if($validator->fails())
        {
           return response()->json(
              [
                  "success" => false,
                  "message" => $validator->errors()->first()
              ],
              400
            );
        }

        $category = Category::create([
            "title" => $request->title
        ]);

       return response()->json(
            [
                "success" => true,
                "message" => "تخصص مورد نظر شما با موفقیت ایجاد شد",
                "category" => $category
            ]
        );
    }
    // ویرایش دسته بندی
    public function update($id,Request $request) : JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                "title" => "required"
            ],
            [
                "title.required" => "لطفا یک عنوان وارد کنید"
            ]
        );

        if($validator->fails())
        {
            return response()->json(
                [
                    "success" => false,
                    "message" => $validator->errors()->first()
                ],
                400
            );
        }

        Category::findOrFail($id)->update($request->all());

        return response()->json([
            "success" => true,
            "message" => "تخصص مورد نظر با موفقیت ویرایش شد"
        ]);
    }
    //حذف دسته بندی
    // دریافت لیست کامل دسته بندی ها
}
