<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\User\UserInterface;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $repository;
    protected $request;

    /**
     * @param \App\Services\User\UserInterface
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return void
     */
    public function __construct(UserInterface $repo, Request $request)
    {
        $this->repository = $repo;
        $this->request = $request;
        $this->middleware(
            'jwt.verify', 
            ['except' => ['authenticate', 'register', 'verifyUserMail']]
        );    
    }

    /**
     * @return mixed
     */
    public function authenticate()
    {
        $credentials = $this->request->only('email', 'password');
        return $this->repository->loginUser($credentials);
    }

    /**
     * @return mixed
     */
    public function register()
    {
        $validator = Validator::make($this->request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        if($validator->fails()){
            return response()->json(
                $validator->errors()
            );
        }
        return $this->repository->signUp($this->request->all());
    }

    /**
     * @return mixed
     */
    public function getAuthenticatedUser()
    {
        return $this->repository->loggedInUser();
    }

    public function verifyUserMail($verfication_token, $target)
    {
        return $this->repository->verifyUserMail($verfication_token, $target);
    }

    public function logout() {
        Auth::logout();
        return response()->json(['success' => 'User successfully signed out']);
    }
}
