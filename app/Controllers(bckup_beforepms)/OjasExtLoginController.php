<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class OjasExtLoginController extends Controller
{
    public function ojas_access()
    {
        $EmployeeId = Auth::user()->EmployeeID;
         // JWT Secret Key
            $secretKey = 'v7n90l9uvy';
            $algorithm = 'HS256';
            // JWT Payload
            $payload = [
                'iss' => 'https://vnrseeds.com', // Issuer
                'sub' => $EmployeeId,           // Subject - Employee ID
                'iat' => time(),                // Issued at
                'exp' => time() + 3600          // Expiration time (1 hour)
            ];
             // Generate JWT Token
             $jwt = JWT::encode($payload, $secretKey, $algorithm);

            // Redirect to Ojas login with the token
            return redirect()->away("https://ojasnew.vnrseeds.co.in/ojas-login?token=$jwt");
    }
   
}
