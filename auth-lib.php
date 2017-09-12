<?php

class Authentication {
  public function __construct($env) {
    $this->env = $env;
    $inifile = $env . ".ini";
    $ini = parse_ini_file($inifile);

    $this->ClientId = $ini['client_id'];
    $this->ClientSecret = $ini['client_secret'];
    $this->RedirectUri = $ini['redirect_uri'];
    $this->AuthorizeUrl = $ini['authorize_url'];
    $this->AccessTokenUrl = $ini['token_url'];
    $this->RevokeTokenUrl = $ini['revoke_token_url'];
    $this->SliceApiBaseUrl = $ini['base_api_url'];
    $this->UseProxy = $ini['use_proxy'];
  }

  public function RequestAccessCode () {
    return($this->AuthorizeUrl . "?type=web_server" .
    "&client_id=" . $this->ClientId .
    "&response_type=code" .
    "&redirect_uri=" . $this->RedirectUri .
    "&state=env%3D" . $this->env);
  }

  // Convert an authorization code from Authorization callback into an access token.
  public function GetAccessToken($auth_code) {
    // Init cUrl.
    $r = $this->InitCurl($this->AccessTokenUrl);

    $post_fields =
    "client_id=" . $this->ClientId .
    "&client_secret=" . $this->ClientSecret .
    "&grant_type=authorization_code" .
    "&code=" . urlencode($auth_code) .
    "&redirect_uri=" . $this->RedirectUri;

    // Obtain and return the access token from the response.
    curl_setopt($r, CURLOPT_POST, true);
    curl_setopt($r, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($r);
    if ($response == false) {
      die("curl_exec() failed. Error: " . curl_error($r));
    }

    //Parse JSON return object.
    return json_decode($response);
  }

  public function RevokeToken($token) {
    // Init cUrl.
    $r = $this->InitCurl($this->RevokeTokenUrl);

    // Assemble POST parameters for the request.
    $post_fields =
    "token=" . urlencode($token) .
    "&client_id=" . $this->ClientId .
    "&client_secret=" . $this->ClientSecret;

    curl_setopt($r, CURLOPT_POST, true);
    curl_setopt($r, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($r);
    if ($response == false) {
      die("curl_exec() failed. Error: " . curl_error($r));
    }

    //Parse JSON return object.
    return json_decode($response);
  }

  public function RefreshToken($refresh_token) {
    // Init cUrl.
    $r = $this->InitCurl($this->AccessTokenUrl);

    // Assemble POST parameters for the request.
    $post_fields =
    "grant_type=refresh_token" .
    "&refresh_token=" . $refresh_token .
    "&client_id=" . $this->ClientId .
    "&client_secret=" . $this->ClientSecret;

    curl_setopt($r, CURLOPT_POST, true);
    curl_setopt($r, CURLOPT_POSTFIELDS, $post_fields);

    $response = curl_exec($r);
    if ($response == false) {
      die("curl_exec() failed. Error: " . curl_error($r));
    }

    //Parse JSON return object.
    // return $response;
    return json_decode($response);
  }

  public function GetUserInfo($access_token) {
    // Init cUrl.
    $r = $this->InitCurl($this->SliceApiBaseUrl . "/api/v1/users/self");

    // Add access token to headers
    curl_setopt($r, CURLOPT_HTTPHEADER, array (
      "Authorization: Bearer " . $access_token
    ));

    $response = curl_exec($r);
    if ($response == false) {
      die("curl_exec() failed. Error: " . curl_error($r));
    }

    //Parse JSON return object.
    // return $response;
    return json_decode($response);
  }

  private function InitCurl($url) {
    $r = null;

    if (($r = @curl_init($url)) == false) {
      header("HTTP/1.1 500", true, 500);
      die("Cannot initialize cUrl session. Is cUrl enabled for your PHP installation?");
    }

    curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
    // Decode compressed responses.
    curl_setopt($r, CURLOPT_ENCODING, 1);
    curl_setopt($r, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($r, CURLOPT_SSL_VERIFYHOST, false);

    if ($this->UseProxy) {
      curl_setopt($r, CURLOPT_PROXY, "http://localhost:8888");
      curl_setopt($r, CURLOPT_PROXYPORT, 8888);
    }

    return($r);
  }
}

?>
