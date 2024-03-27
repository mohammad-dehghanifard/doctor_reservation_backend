<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function create(Request $request) : JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "mobile" => "required|max:11|min:11",
                "address" => "required",
                "resume" => "required",
                "category_id" => "required|exists:categories,id"
            ]
        );

        if ($validator->fails())
        {
            return response() -> json(
                [
                    "success" => false,
                    "message" => $validator -> errors() -> first()
                ],
                400
            );
        }

        $doctor = Doctor::create($request->all());

        return response() -> json(
            [
                "success" => true,
                "message" => "دکتر جدید با موفقیت اضافه شد",
                "doctor" => $doctor
            ]
        );
    }

    public function update($id,Request $request) : JsonResponse
    {

        $validator = Validator::make(
            $request->all(),
            [
                "mobile" => "max:11|min:11",
                "category_id" => "exists:categories,id"

            ]
        );

        if ($validator->fails())
        {
            return response() -> json(
                [
                    "success" => false,
                    "message" => $validator -> errors() -> first()
                ],
                400
            );
        }

        Doctor::findOrFail($id) -> update($request ->all());

        return response() -> json(
            [
                "success" => true,
                "message" => "دکتر مورد نظر با موفقیت ویرایش شد"
            ]
        );
    }

    public function delete($id) : JsonResponse
    {
        Doctor::findOrFail($id) -> delete();

        return response() -> json([
            "success" => true,
            "message" => "دکتر مورد نظر با موفقیت حذف شد"
        ]);
    }

    public function fetch(): AnonymousResourceCollection
    {
       return DoctorResource::collection(Doctor::with("category") -> get());
    }
}
