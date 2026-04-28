<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        $authenticatedUser = auth()->user();

        if($authenticatedUser)
        {
            $categoryCollection = Category::all();

            return view('categories', ['categories' => $categoryCollection]);
        }

        return view('admin_login');
    }

    public function authenticate()
    {
        $credentialsValidator = validator(request()->all(), [
            "email" => "required",
            "password" => "required"
        ]);

        if($credentialsValidator->fails()) return back()->withInput()->withErrors($credentialsValidator->errors());

        if(!auth()->attempt($credentialsValidator->validated())) return back()->withErrors(["error" => "Неверный логин или пароль"]);

        $authenticatedUser = auth()->user();

        if($authenticatedUser->role !== 'ADMIN')
        {
            auth()->logout();
            return back()->withErrors(["error" => "?"]);
        }

        return back();
    }

    public function logout() {
        auth()->logout();
        return redirect('/admin');
    }
}
