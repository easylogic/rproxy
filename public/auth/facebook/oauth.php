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

const CLIENT_ID     = '121058788072437';
const CLIENT_SECRET = 'e3a2a49e294c68192b11b0d557d1d1cd';

const REDIRECT_URI           = 'http://rproxy.easylogic.co.kr/auth/facebook/oauth.php';
const AUTHORIZATION_ENDPOINT = 'https://graph.facebook.com/oauth/authorize';
const TOKEN_ENDPOINT         = 'https://graph.facebook.com/oauth/access_token';

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

    $_SESSION['state'] = 2;
    $_SESSION['token'] = $info['access_token'];    
    $_SESSION['oauth'] = 'facebook';
    $_SESSION['name'] = $response['result']['username'];
    
    header('Location: /');
}

?>