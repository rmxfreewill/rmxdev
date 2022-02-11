<?php

//Line Api
function rmxChangeMemberRichMenu($type, $LINEID)
{
    if ($type == 'LOGOUT') {
        $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu";
        $method = 'DELETE';
    } else if ($type == 'REGISTER') {
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

function sendMessage($replyJson)
{
    $url = "https://api.line.me/v2/bot/message/multicast";

    $sendInfo['URL'] = $url;
    $sendInfo['AccessToken'] = "6DOzScAqBRwD/oRPwvMFua/SBvgLtXciCay4cwK10oTPA88R60mjeGdeW8NDL61dCJX2EtyHINFcj1DvY0mboZntH38a/fhTRI3rCaN4vDI/zWBCl0ze5K/AV2JoxoCwR9OZXj2Y7rHn6nABPwZMVwdB04t89/1O/w1cDnyilFU=";

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
