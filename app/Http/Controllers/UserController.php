<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        return view('layout.layouts');
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'patronymic' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:2|confirmed',
            'gender' => 'nullable|in:w,m',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'patronymic' => $request->patronymic,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'role' => $request->role,
            ]);

            return redirect()->route('login')->with('success', 'Регистрация прошла успешно!');
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function signup(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('profile')->with('success', 'Авторизация прошла успешно!');
        }

        return redirect()->back()->withErrors(['email' => 'Неправильные учетные данные.'])->withInput($request->only('email'));
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('home')->with('success', 'Вы вышли из системы!');
    }

    public function show()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get(); 

        return view('auth.profile', compact('user', 'orders'));
    }
    
}
