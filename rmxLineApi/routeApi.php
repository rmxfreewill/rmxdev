<?php



include_once("rmxProfileApi.php");
include_once("rmxTicketApi.php");


error_reporting(-1);
ini_set('display_errors', 'On');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function getDataUrl()
{
    $get_string = $_SERVER['QUERY_STRING'];
    parse_str($get_string, $get_array);
    return  $get_array;
}

function checkRequest()
{
    $bearer_token = "6DOzScAqBRwD/oRPwvMFua/SBvgLtXciCay4cwK10oTPA88R60mjeGdeW8NDL61dCJX2EtyHINFcj1DvY0mboZntH38a/fhTRI3rCaN4vDI/zWBCl0ze5K/AV2JoxoCwR9OZXj2Y7rHn6nABPwZMVwdB04t89/1O/w1cDnyilFU=";
    $header_token = trim($_SERVER['HTTP_AUTHORIZATION'], 'Bearer ');
    $isToken = $bearer_token == $header_token;
    $requestMethod = $_SERVER["REQUEST_METHOD"] == 'POST';
    return $requestMethod == $isToken;
}

$checkReq = $_SERVER['HTTP_AUTHORIZATION'] == null ? false : checkRequest();
if ($checkReq == true) {
    $lineid = getDataUrl()['lineid'];
    $menu = getDataUrl()['menu'];
    if ($menu == 'profile') {
        rmxApiGetProfile($lineid);
    } else if ($menu == 'ProfileAndSoldtocode') {
        rmxApiGetSoldToCodeAndLineId($lineid);
    } else if ($menu == 'ticketdetails') {
        rmxApiGetTicketDetails($lineid);
    } else {
        echo '{}';
    }
}
