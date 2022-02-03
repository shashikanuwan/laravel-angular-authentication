<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request)
    {
        $this->getPasswordResetTableRow($request)->count() > 0 ? $this->changePasword($request) : $this->tokenNotFoundResponce();
    }

    private function getPasswordResetTableRow($request)
    {
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->resetToken
        ]);
    }

    private function tokenNotFoundResponce()
    {
        return response()->json(
            ['error' => 'Token or Email is incorrect'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    private function changePasword($request)
    {
        $user = User::whereEmail($request->email)->first();
        $user->update(['password' => $request->password]);
        $this->getPasswordResetTableRow($request)->delete();

        return response()->json(
            ['data' => 'Password Successfully Changed'],
            Response::HTTP_CREATED
        );
    }
}
