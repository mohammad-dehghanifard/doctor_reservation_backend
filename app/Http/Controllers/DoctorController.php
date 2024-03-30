<?php

namespace App\Http\Controllers;

use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\Reservation;
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

    public function fetch(Request $request): AnonymousResourceCollection
    {
       $doctorList = Doctor::with("category");

       if ($request->has("keyword"))
       {
           $doctorList -> where("name","LIKE","%" .$request->keyword ."%");
       }

       if($request->has("category_id"))
       {
           $doctorList -> where("category_id",$request->category_id );
       }

       if ($request->has("resume_keyword"))
       {
           $doctorList -> where("resume","LIKE","%". $request->resume_keyword ."%");
       }

       return DoctorResource::collection($doctorList -> get());
    }

    public function reserve(Request $request) : JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                "doctor_id" => "required|exists:doctors,id",
                "date" => "required"
            ]
        );

        if($validator->fails())
        {
            return response() -> json(
                [
                    "success" => false,
                    "message" => $validator ->errors() -> first()
                ],
                400
            );
        }

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $reserve = Reservation::create($data);

        return response() ->json(
            [
                "success" => true,
                "message" => "رزرو شما با موفیت انجام شد",
                "reserve" => $reserve
            ]
        );
    }

    public function fetchReservation(Request $request)
    {
        return $request -> user() -> reservations;
    }

}
