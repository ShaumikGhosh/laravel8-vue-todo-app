<?php

namespace App\Services\User;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Models\VerifyUser;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Str;

class UserService implements UserInterface 
{
    protected $user;
    protected $verify_user;

    public function __construct (User $user, VerifyUser $vu)
    {
        $this->user = $user;
        $this->verify_user = $vu;
    }

    public function signUp (array $data)
    {
        $user = $this->user::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $code = Str::random(40);
        $this->verify_user::create([
            'verification_code' => $code,
            'user_id' => $user['id']
        ]);
        $target = base64_encode($data['email']);
        $details = [
            'title' => 'Mail from laravel+vue aplication',
            'url' => env('FRONTEND_URL')."/login?verify_token=$code&&target=$target",
        ];
        Mail::to($data['email'])->send(new TestMail($details));
        return response()->json(['message' => 'User successfully registered and a verification mail has been sent to you, email verification required before login. Thanks.', 'status'=>'success'],201);
    }

    public function loginUser (array $data)
    {
        try {
            $credentials = ['email' => $data['email'], 'password' => $data['password']];
            
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials provided!']);
            }
            else{
                if (! $token = JWTAuth::attempt(array_merge($credentials, ['email_verified'=>true]))) {
                    return response()->json(['error' => 'You can not login till email is verified, please check your email and verify now!']);
                }
            }
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Could not create the token!'], 500);
        }
        return response()->json(compact('token'));
    }

    public function loggedInUser ()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getMessage());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getMessage());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getMessage());
        }
        return response()->json(compact('user'));
    }

    public function verifyUserMail($verfication_token, $target)
    {
        $email = base64_decode($target);
        $user = $this->user::where('email', $email)->first();
        if($user->user_status->verification_code == $verfication_token )
        {
            $user->email_verified = true;
            $user->save();
            return response()->json(['success' => 'We have succesfully verifed you, you can login now.']);
        }
        return response()->json(['error' => 'There is something wrong you are trying with.']);
    }
}