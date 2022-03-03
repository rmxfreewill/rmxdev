<?php

// include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");

function rmxGetDataLiffv1($menu, $LineId)
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
