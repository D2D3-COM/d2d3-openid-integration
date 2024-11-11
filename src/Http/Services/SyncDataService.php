<?php

namespace D2d3\OpenidIntegration\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class SyncDataService
{

  public static function syncUser()
  {
      $users = User::select('email', 'email_verified_at', 'first_name', 'last_name', 'phone', 'password')->get()->makeVisible('password');

      $response = Http::post(env('D2D3_OID_USER_SYNC_URL'), [
        'users' => $users,
        'client_id' => env('D2D3_OID_CLIENT_ID'),
        'client_secret' => env('D2D3_OID_CLIENT_SECRET'),
        'redirect_uri' => env('D2D3_OID_REDIRECT_URI'),
      ]);

      return [
        'status' => $response->getStatusCode(),
        'result' => $response->json(),
      ];
  }
}
