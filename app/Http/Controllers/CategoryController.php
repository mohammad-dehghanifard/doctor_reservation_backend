<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
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
}
