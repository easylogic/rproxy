<?php

$req_url = 'https://api.twitter.com/oauth/request_token';
$authurl = 'https://api.twitter.com/oauth/authorize';
$acc_url = 'https://api.twitter.com/oauth/access_token';
$api_url = 'https://api.twitter.com/1.1';

$conskey = 'jJMKFe2cuxxQ3q02zuVZtw';
$conssec = 'cONzAArfL94MrlEZyaa4ZPWikHueVMxTMcPRupet0';

session_start();

require('Client.php');
require('GrantType/IGrantType.php');
require('GrantType/AuthorizationCode.php');

const CLIENT_ID     = '204801737965.apps.googleusercontent.com';
const CLIENT_SECRET = 'W_2Lttr2U6SD3gKskSB4AbOL';

const REDIRECT_URI           = 'http://rproxy.easylogic.co.kr/auth/google/oauth.php';
const AUTHORIZATION_ENDPOINT = 'https://accounts.google.com/o/oauth2/auth';
const TOKEN_ENDPOINT         = 'https://accounts.google.com/o/oauth2/auth';

$client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET);
if (!isset($_GET['code']))
{
    $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
    header('Location: ' . $auth_url);
    die('Redirect');
}
else
{
    $params = array('code' => $_GET['code'], 'redirect_uri' => REDIRECT_URI);
    $response = $client->getAccessToken(TOKEN_ENDPOINT, 'authorization_code', $params);
    parse_str($response['result'], $info);
    $client->setAccessToken($info['access_token']);
    $response = $client->fetch('https://graph.facebook.com/me');

    print_r($response, true);

    $_SESSION['state'] = 2;
    $_SESSION['token'] = $info['access_token'];    
    $_SESSION['oauth'] = 'google';
    $_SESSION['name'] = $response['result']['username'];
    
}

?>