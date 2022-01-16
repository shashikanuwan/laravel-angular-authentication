<?php

namespace App\Http\Controllers;

use App\Mail\ResetPsswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        if (!$this->validateEmail($request->email)) {
            return $this->failedResponce();
        }

        $this->send($request->email);
        return $this->successResponce();
    }

    public function send($email)
    {
        Mail::to($email)->send(new ResetPsswordMail());
    }

    public function validateEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    public function failedResponce()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successResponce()
    {
        return response()->json([
            'error' => 'Reset Email is send successfully, please check your email'
        ], Response::HTTP_OK);
    }
}
