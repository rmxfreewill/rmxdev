

<?php
/* 
https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/reply&token=m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=
&value={"replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/quota/consumption
https://api.line.me/v2/bot/message/delivery/reply?date={yyyyMMdd}
https://api.line.me/v2/bot/message/delivery/reply?date=20210915


https://rmxline.herokuapp.com/linePush.php

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/push&value={"to":"@728ohvhl","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}


*/
    ini_set('max_input_time','500');
    ini_set('max_execution_time','500'); 
    set_time_limit(300); 


/*Get Data From POST Http Request*/
$datas = file_get_contents('php://input');
if ($datas) {

    //$CompanyToken = "m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=";
    $CompanyToken="nYd6+jN9a0M7ctdhnXJp7dz5VKt27XCWAv8aVT9G7v4zIjBOKUAjKONAzoFEO3YhP43SS9hPR5PSPluwnjjmG/AQsUBhssqq2SYuLh6VP7waza6lcPQycF7Jsn5ZD5F2vx8VAl5/UIWulq/JdyT1pAdB04t89/1O/w1cDnyilFU=";
    $CompanyId = "00001";
    //$CompanyUrl = "http://rmxcell.pe.hu/rmxLineCmd.php";
    $CompanyUrl="http://119.46.97.156/rmxline/rmxLineCmd.php";

    $UrlReply= "https://api.line.me/v2/bot/message/reply";
    $UrlMulticast= "https://api.line.me/v2/bot/message/multicast";

    $deCode = json_decode($datas,true);

    $replyToken = $deCode['events'][0]['replyToken'];
    $userId = $deCode['events'][0]['source']['userId'];
    $text = $deCode['events'][0]['message']['text'];

    /*=================================================================*/

    if ($text === "®Register"){
        $msg = "text (".$response.")(".$text.")";
        line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
    
    } else if ($text === "®Complete Register"){
        //$msg = "text (".$response.")(".$text.")";
        //line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
    } else {        
        if(!empty($text)){   
            checkUserRegister($userId,$CompanyId,$CompanyUrl,$UrlReply
                ,$CompanyToken,$replyToken,$text);     
        } 
        put_request($CompanyUrl,$userId,$CompanyId,$text,$datas);
    }
   //


    http_response_code(200);

}



function checkUserRegister($userId,$CompanyId,$CompanyUrl,$UrlReply
    ,$CompanyToken,$replyToken,$text){

    $Command="call sp_main_check_register ('".$userId."','".$CompanyId."')";
    $curl_data = "Command=".$Command;
    $response = post_web_content($CompanyUrl,$curl_data);

    $asRet = explode("^c", $response);
    if (count($asRet) >=4){
        $nFlg = $asRet[1];
        $sMMsg = $asRet[0];
     
        if ($nFlg =="3" || $nFlg =="4"  || $nFlg =="5"){
            
                //$sUserName = $asRet[2];
                //$sEMail = $asRet[3];
                //$sMobileNo = $asRet[4];
                //updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$sUserName,$sEMail,$sMobileNo);

                $sUserName = $asRet[2];
                $msg = "สวัสดีครับคุณ" . $sUserName ."\n"
                    ." ข้อความที่ส่งมา จะถูกส่งต่อให้ Admin \n\n '".$text."'";
                line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                              
            
        } else {
            $sUserName = $asRet[2];
            $msg = 'ยังไม่ได้ลงทะเบียน กรุณาลงทะเบียน ก่อนการส่งข้อความครับ';
            line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
        }
    }
    return "";
}
/*
function updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$sUserName,$sEMail,$sMobileNo){    
    $Command="call sp_main_request_register ('".$userId."','".$CompanyId
        ."','".$sUserName."','".$sEMail."','".$sMobileNo."')";
    $curl_data = "Command=".$Command;
    $response = post_web_content($CompanyUrl,$curl_data);

    return $response;
}
*/

function getFormatTextMessage($text)
{
    $datas = [];
    $datas['type'] = 'text';
    $datas['text'] = $text;

    return $datas;
}

function sentMessage($encodeJson,$datas)
{
    $datasReturn = [];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $datas['url'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $encodeJson,
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer ".$datas['token'],
        "cache-control: no-cache",
        "content-type: application/json; charset=UTF-8",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $err;
    } else {
        if($response == "{}"){
        $datasReturn['result'] = 'S';
        $datasReturn['message'] = 'Success';
        }else{
        $datasReturn['result'] = 'E';
        $datasReturn['message'] = $response;
        }
    }

    return $datasReturn;
}


function post_web_page( $url,$curl_data )
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
    curl_setopt_array($ch,$options);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch) ;
    $header  = curl_getinfo($ch);
    curl_close($ch);

  //  $header['errno']   = $err;
  //  $header['errmsg']  = $errmsg;
  //  $header['content'] = $content;
    return $header;
}




function post_web_content( $url,$curl_data )
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
    curl_setopt_array($ch,$options);
    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch) ;
    $header  = curl_getinfo($ch);
    curl_close($ch);

  //  $header['errno']   = $err;
  //  $header['errmsg']  = $errmsg;
  //  $header['content'] = $content;
  
    return trim($content);
}


function line_reply($url,$CompanyToken,$userId,$replyToken,$msg){
    //$msg = "ถามอะไรมาก็ตอบได้ UserId[" . $userId."] ".$text."[replay[".$replyToken."]]";
   
    $LINEDatas['url'] = $url;
    $LINEDatas['token'] = $CompanyToken;

    $messages = [];
    $messages['replyToken'] = $replyToken;
    $messages['messages'][0] = getFormatTextMessage($msg);

    $encodeJson = json_encode($messages);

    $results = sentMessage($encodeJson,$LINEDatas);
}

function line_multicast($url,$CompanyToken,$userId,$msg){

    $LINEDatas['url'] = $url;
    $LINEDatas['token'] = $CompanyToken;

    //$msg = "push message \n[" . $userId."]";
    $messages = [];
    $messages['to'][0] = $userId;
    $messages['messages'][0] = getFormatTextMessage($msg);
    
    $encodeJson = json_encode($messages);
    $results = sentMessage($encodeJson,$LINEDatas);
}


function put_request($CompanyUrl,$userId,$CompanyId,$text,$datas){

    $Command="call sp_comp_insert_user_resquest ('".$userId."','".$CompanyId."','".$text."','".$datas."')";
    $curl_data = "LineId=".$userId."&CompanyCode=".$CompanyId."&Command=".$Command;    

    $response = post_web_page($CompanyUrl,$curl_data);

}


   /*
        $Command="call sp_main_check_register ('".$userId."','".$CompanyId."')";
        $curl_data = "Command=".$Command;
        $response = post_web_content($CompanyUrl,$curl_data);

        $response = trim($response);
        $asRet = explode("^c", $response);
        if (count($asRet) >=4){
            $nFlg = $asRet[1];
            $sMMsg = $asRet[0];
            if ($nFlg =="-1"){

                $msg = $sMMsg;
                line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);

                updateRegisterFlag($CompanyUrl,$userId,$CompanyId,"","","");
            } else  if ($nFlg =="0"){
                if (!preg_match("/^[a-zA-Z-' ]*$/",$text)) {
                    $msg = "Only letters and white space allowed (".$text.")";
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                } else {                
                    $msg = $sMMsg;
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                    updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$text,"","");
                }
            } else  if ($nFlg =="1"){

                if (!filter_var($text, FILTER_VALIDATE_EMAIL)) {
                    $msg = "Invalid email format (".$text.")";
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                } else {                

                    $sUserName = $asRet[2];
                    $sEMail = $asRet[3];
                    $sMobileNo = $asRet[4];

                    $msg = $sMMsg;
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                    updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$sUserName,$text,"");
                }

            } else  if ($nFlg =="2"){

                if (!preg_match('/^[0-9]{10}+$/',$text)) {
                    $msg = "Invalid mobile format (".$text.")";
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                } else {
                    $sUserName = $asRet[2];
                    $sEMail = $asRet[3];
                    $sMobileNo = $asRet[4];

                    $msg = $sMMsg;
                    line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                    updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$sUserName,$sEMail,$text);
                }
            } else  if ($nFlg =="3"){
                $sUserName = $asRet[2];
                $sEMail = $asRet[3];
                $sMobileNo = $asRet[4];

                $msg = $sMMsg;
                line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
                updateRegisterFlag($CompanyUrl,$userId,$CompanyId,$sUserName,$sEMail,$sMobileNo);
            } else {
                $sUserName = $asRet[2];
                $msg = "สวัสดีครับคุณ" . $sUserName ."\n"
                    ." ข้อความที่ส่งมา จะถูกส่งต่อให้ Admin \n\n '".$text."'";
                line_reply($UrlReply,$CompanyToken,$userId,$replyToken,$msg);
            }
        }
        */

?>
