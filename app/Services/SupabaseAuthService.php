<?php

namespace App\Services;

use GuzzleHttp\Client;

class SupabaseAuthService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('SUPABASE_URL') . '/auth/v1/',
            'headers' => [
                'apikey' => env('SUPABASE_ANON_KEY'),
                'Authorization' => 'Bearer ' . env('SUPABASE_ANON_KEY'),
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function registerUser($email, $password)
    {
        $response = $this->client->post('signup', [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function loginUser($email, $password)
    {
        $response = $this->client->post('token?grant_type=password', [
            'json' => [
                'email' => $email,
                'password' => $password
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getUser($accessToken)
    {
        $response = $this->client->get('user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
