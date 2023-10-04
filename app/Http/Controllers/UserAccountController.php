<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function create(){
        return inertia('UserAccount/Create');
    }

    public function store(ValidateUserRequest $request){
        $user=User::create($request->validated());
        Auth::login($user);

        return redirect()->route('listing.index')
        ->with('success','Account successfully created!');
    }
}
