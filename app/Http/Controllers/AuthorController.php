<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class AuthorController extends Controller
{
    function author_register(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>['required','unique:authors'],
            'password'=>['required', Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()]


        ]);
        Author::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('author_register','Registrations Success!Your Account is pending for Approval!We will get confirmation mail when your account will active!');
        
    }
}
