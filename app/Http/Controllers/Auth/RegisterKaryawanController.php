<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterKaryawanController extends Controller
{

    use RegistersUsers;

    public function create()
    {
        return view("karyawan.register");
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::create(request(['name', 'email', 'password', 'role']));

        auth()->login($user);

        return redirect()->to('/home');
    }
}
