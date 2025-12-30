<?php

namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DadosService;
use App\Http\Requests\StoreDadosUser;

class ControllerUser extends Controller
{
    protected UserService $userService;
    protected DadosService $dadosService;
    public function __construct(UserService $userService, DadosService $dadosService)
    {
        $this->userService = $userService;
        $this->dadosService = $dadosService;
    }

    public function index()
    {
        return view('users.index');
    }

    public function store(StoreDadosUser $request)
    {
         try {
             $user = $this->userService->registerUser($request->all());
             $dadosUsuario = $this->dadosService->getAllByUserId($user->id);
             return redirect()->route('login.index')->with('success', 'User registered successfully!' . $dadosUsuario);
         } catch (\Exception $e) {
             return redirect()->back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
         }
    }

    public function getUserByEmail(Request $request, $email)
    {
        $user = $this->userService->getUserByEmail($email);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
    }

    

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index')->with('success', 'You have been logged out successfully!');
    }
}

      