<?php

namespace App\Services\User;


interface UserInterface 
{
    public function signUp (array $data);

    public function loginUser (array $data);

    public function loggedInUser ();

    public function verifyUserMail($verfication_token, $target);
}