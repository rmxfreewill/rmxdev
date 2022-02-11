<?php

// include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");

function rmxChangeMemberRichMenu($type, $LINEID)
{
    if ($type == 'LOGOUT') {
        $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu";
        $method = 'DELETE';
    } else if ($type == 'Member') {
        $CURLOPT = CURLOPT_POST;
        $RICHMENUID = RICHMENU_ID;
        $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu/$RICHMENUID";
        $method = "POST";
    }
    $data = array();
    $headers = [
        "Authorization: Bearer " . BEARER_TOKEN
    ];
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

function rmxGetDataLiff($menu, $LineId)
{
    // $rmx_api_url = RMX_HEROKU_API_URL;
    $rmx_api_url = RMX_SERVER_API_URL;
    $param_menu = "?menu=$menu&lineid=$LineId";

    // if ($mobileNo != '') {
    //     $param_mobileno = "&mobile=$mobileNo";
    // } else {
    //     $param_mobileno = '';
    // }

    $url = $rmx_api_url  . $param_menu;
    $headers = ["Authorization: Bearer " . BEARER_TOKEN];

    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        $data = curl_exec($ch);
        curl_close($ch);
        return  $data;
    } catch (Exception $ex) {
        print('Error rmxProfileLiff: ' . $ex);
    }
}

function postWebContent($url, $curl_data)
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,         // return web page
        CURLOPT_HEADER         => false,        // don't return headers
        CURLOPT_FOLLOWLOCATION => true,         // follow redirects
        CURLOPT_ENCODING       => "",           // handle all encodings
        CURLOPT_USERAGENT      => "kai",     // who am i
        CURLOPT_AUTOREFERER    => true,         // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
        CURLOPT_TIMEOUT        => 120,          // timeout on response
        CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
        CURLOPT_POST            => 1,            // i am sending post data
        CURLOPT_POSTFIELDS     => $curl_data,    // this are my post vars
        CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
        CURLOPT_SSL_VERIFYPEER => false,        //
        CURLOPT_VERBOSE        => 1                //
    );

    $ch      = curl_init($url);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close($ch);

    return trim($content);
}
