<?php

namespace D2d3\OpenidIntegration\Http\Services;

use Illuminate\Support\Facades\Http;

class OauthService
{

  /**
   * Login with an authorization code.
   *
   * @param string $code Authorization code obtained after user login.
   * @return array User information returned by RP db.
   */
  static public function loginWithAuthCode($code)
  {
    $tokenResponse = self::getToken($code);
    if (isset($tokenResponse['access_token'])) {
      $userData = self::getUser($tokenResponse['access_token']);
      if(isset($userData['email'])) {
        return $userData;
      }
      return ['error' => "Can't get user info"];
    }
    return ['error' => 'Access token not found in the response'];
  }

  /**
   * Get an access token from the OAuth provider.
   *
   * @param string $code Authorization code received from OAuth login.
   * @return array Response from the OAuth provider containing the access token and other data.
   */
  static public function getToken($code)
  {
    $response = Http::post(env('D2D3_OID_OAUTH_TOKEN_URL'), [
      'code' => $code,
      'grant_type' => 'authorization_code',
      'client_id' => env('D2D3_OID_CLIENT_ID'),
      'client_secret' => env('D2D3_OID_CLIENT_SECRET'),
      'redirect_uri' => env('D2D3_OID_REDIRECT_URI'),
    ]);

    return $response->json();
  }

  /**
   * Get user information using the access token.
   *
   * @param string $accessToken Access token to authenticate the request.
   * @return array User information returned by the OAuth provider.
   */
  static public function getUser($accessToken)
  {
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $accessToken,
    ])->get(env('D2D3_OID_USER_INFO_URL'));

    return $response->json();
  }

}
