<?php

include_once("define_Global.php");

$GLOBALS['RICHMENU_ID'] =  RICHMENU_ID;
$GLOBALS['BEARER_TOKEN'] =  BEARER_TOKEN;

function callCURL($url, $method)
{

    $headers = [
        "Authorization: Bearer " . $GLOBALS['BEARER_TOKEN']
    ];
    $data = array();
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        // curl_setopt($ch, $CURLOPT, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $data
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); # receive server response
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); # do not verify SSL
        $data = curl_exec($ch); # execute curl
        $httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); # http response status code
        curl_close($ch);

        $data = "{}";
    } catch (Exception $ex) {
        $data = $ex;
    }
}



function rmxChangeRegisterRichMenu($LINEID)
{

    $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu";
    $method = 'DELETE';
    callCURL($url, $method);
}

function sendMessage($replyJson)
{
    // $url = "https://api.line.me/v2/bot/message/multicast";
    $url = "https://api.line.me/v2/bot/message/push";

    $sendInfo['URL'] = $url;
    $sendInfo['AccessToken'] = $GLOBALS['BEARER_TOKEN'];

    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendInfo['URL']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $replyJson
        );
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $sendInfo["AccessToken"]
            )
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); # receive server response
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); # do not verify SSL
        $data = curl_exec($ch); # execute curl
        $httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); # http response status code
        curl_close($ch);

        $data = $data;
    } catch (Exception $ex) {
        $data = $ex;
    }
    return $data;
}
