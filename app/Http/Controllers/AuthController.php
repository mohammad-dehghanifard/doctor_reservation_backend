<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => "required",
                "username" => "required|unique:users,username",
                "gender" => "required|in:male,female",
                "mobile" => "required|unique:users,mobile",
                "password" => "required|min:6"
            ]
        );

        if($validator -> fails())
        {
            return response() -> json(
                [
                    "success" => false,
                    "message" => $validator ->errors()->first()
                ],
                400
            );
        }

        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        User::create($data);

        return response() -> json(
            [
                "success" => true,
                "message" => "ثبت نام با موفقیت انجام شد"
            ]
        );
    }
}
