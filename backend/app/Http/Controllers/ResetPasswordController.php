<?php

namespace App\Http\Controllers;

use App\Mail\ResetPsswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

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
        $this->createToken($email);
        $token = $this->getToken($email);
        Mail::to($email)->send(new ResetPsswordMail($token));
    }

    public function getToken($email)
    {
        $table = $this->checkToken($email);
        return $table->token;
    }

    public function createToken($email)
    {
        $oldToken = $this->checkToken($email);
        if ($oldToken) {
            return $oldToken;
        }
        $token = Str::random(60);
        $this->saveToken($token, $email);
    }

    public function checkToken($email)
    {
        return DB::table('password_resets')->where('email', $email)->first();
    }

    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
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
