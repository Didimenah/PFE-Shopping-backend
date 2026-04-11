<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class AuthController extends Controller
{

    // Register Client
    public function registerClient(Request $request)
    {

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:UTILISATEUR,email',
            'telephone' => 'required',
            'mot_de_passe' => 'required|min:6'
        ]);

        $user = Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => 'client'
        ]);

        return response()->json([
            'message' => 'Client créé',
            'user' => $user
        ],201);
    }


    // Register Commercant
    public function registerCommercant(Request $request)
    {

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:UTILISATEUR,email',
            'telephone' => 'required',
            'mot_de_passe' => 'required|min:6'
        ]);

        $user = Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => 'commercant'
        ]);

        return response()->json([
            'message' => 'Commercant créé',
            'user' => $user
        ],201);
    }


    // Login
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'mot_de_passe' => 'required'
        ]);

        $user = Utilisateur::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->mot_de_passe, $user->mot_de_passe))
        {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login réussi',
            'token' => $token,
            'user' => $user
        ]);
    }


    // Get Current User
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }


    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout réussi'
        ]);
    }


    // Forgot Password (Send OTP)
    public function forgotPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Utilisateur::where('email',$request->email)->first();

        if(!$user)
        {
            return response()->json([
                'message'=>'Utilisateur introuvable'
            ],404);
        }

        // 🔐 Anti Spam Protection (1 minute)
        $existing = DB::table('PASSWORD_OTP')
            ->where('email',$request->email)
            ->first();

        if($existing && now()->diffInSeconds($existing->created_at) < 60)
        {
            return response()->json([
                'message'=>'Attendez 1 minute avant de redemander OTP'
            ],429);
        }

        $otp = rand(100000,999999);

        DB::table('PASSWORD_OTP')->updateOrInsert(
            ['email'=>$request->email],
            [
                'otp_code'=>$otp,
                'created_at'=>now()
            ]
        );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json([
            'message'=>'OTP envoyé à votre email'
        ]);
    }


    // Reset Password
    public function resetPassword(Request $request)
    {

        $request->validate([
            'email'=>'required|email',
            'otp'=>'required',
            'password'=>'required|min:6'
        ]);

        $record = DB::table('PASSWORD_OTP')
            ->where('email',$request->email)
            ->where('otp_code',$request->otp)
            ->first();

        if(!$record)
        {
            return response()->json([
                'message'=>'OTP invalide'
            ],400);
        }

        // ⏱ OTP Expiration (10 minutes)
        if(now()->diffInMinutes($record->created_at) > 10)
        {
            return response()->json([
                'message'=>'OTP expiré'
            ],400);
        }

        $user = Utilisateur::where('email',$request->email)->first();

        $user->mot_de_passe = Hash::make($request->password);
        $user->save();

        DB::table('PASSWORD_OTP')
            ->where('email',$request->email)
            ->delete();

        return response()->json([
            'message'=>'Mot de passe changé'
        ]);
    }

}