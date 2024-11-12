<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupabaseAuthService;

class AuthController extends Controller
{
    protected $supabaseAuth;

    public function __construct(SupabaseAuthService $supabaseAuth)
    {
        $this->supabaseAuth = $supabaseAuth;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $result = $this->supabaseAuth->registerUser($data['email'], $data['password']);

        return response()->json($result);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $result = $this->supabaseAuth->loginUser($data['email'], $data['password']);

        if (isset($result['access_token'])) {
            // Store token in the session or however you handle authenticated state
            session(['access_token' => $result['access_token']]);
        }

        return response()->json($result);
    }

    public function getUser(Request $request)
    {
        $accessToken = session('access_token'); // Retrieve the access token from session

        if (!$accessToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = $this->supabaseAuth->getUser($accessToken);

        return response()->json($user);
    }
}
