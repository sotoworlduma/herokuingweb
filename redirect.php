<?php
require_once 'vendor/autoload.php';

// init configuration
//AIzaSyD4CyuxP5gOEM_X2BqjSXidkngB_Hr8h1Y
$clientID = '648088050103-v0lgk85q7vgs1b5eoi3jm4568qrut8tg.apps.googleusercontent.com';
//'970542370866-mfbu6qoqof18qerjrp6ou2s3hj013826.apps.googleusercontent.com';
$clientSecret = 'dr64M8pcjztNQ90RbljWllmJ';
//'bNmBRbjOZ9jMi_bd1dp2Qf6L';
$redirectUri = 'https://polar-wave-13444.herokuapp.com/redirect.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;
  $_SESSION["google"] = $name;
  $_SESSION["googlecorreo"] = $email;

  echo $email;
  echo $name;
  echo $google_account_info;
  header("Location: item.php");

  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>
