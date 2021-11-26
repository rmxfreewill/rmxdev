

<?php
/* 
https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/reply&token=m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=
&value={"replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/quota/consumption
https://api.line.me/v2/bot/message/delivery/reply?date={yyyyMMdd}
https://api.line.me/v2/bot/message/delivery/reply?date=20210915

https://rmxline.herokuapp.com/linePush.php
https://rmxline.herokuapp.com/rmxPost.php
*/
    ini_set('max_input_time','500');
    ini_set('max_execution_time','500'); 
    set_time_limit(300); 
/*
    $urlLink='';
    if (isset($_GET['link'])) {
        $urlLink =$_GET['link'];
       // echo $urlLink;    
    } else {
        $urlLink='http://rmxcell.pe.hu/rmxLineCmd.php?Command=call sp_main_select_company("")';
    }
    //id=@728ohvhl
   

    $compId='';
    if (isset($_GET['compId'])) {
        $compId =$_GET['compId'];
    } else {
        $compId = "00001";
    }



    $tokenlLink='';
    if (isset($_GET['token'])) {
        $tokenLink =$_GET['token'];
        //echo $tokenLink;    
    } else {
        $tokenlLink='m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=';
    }



    $jsonLink='';
    if (isset($_GET['value'])) {
        $jsonLink =$_GET['value'];
        //echo $jsonLink;    
    } else {      
        
        $jsonLink= '{
            "to":"@728ohvhl",
            "messages":[
                {
                    "type":"text",
                    "text":"Hello, user"
                },
                {
                    "type":"text",
                    "text":"May I help you?"
                }
            ]
        }';
        
    }



    $data = http_build_query(array(
        "LineId"  => $tokenlLink,
        "CompanyCode" => $compId,
        "Command" => $jsonLink
        
        ));

    */

    //$curl_data = "var1=60&var2=test";
    //$curl_data = "LineId=t00ssssss30&CompanyCode=00001&Command=call sp_comp_insert_user_resquest ('test0044','00001','test send text22222','test send message22222')";
    $LineId="Ucd102187a2dfb7494ea9d723a5ae4041";
    $CompanyCode="00001";
    $CompanyToken = "m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=";

    //$Command = "call sp_comp_insert_user_resquest ('".$LineId."','".$CompanyCode."','test send text22222','test send message22222')";
    $Command = "call sp_main_check_company_user('".$LineId."','".$CompanyCode."','".$CompanyToken."')";
    //$curl_data = "LineId=".$LineId."&CompanyCode=".$CompanyCode."&Command=".$Command;
    $curl_data = "Command=".$Command;
    //$url = "http://rmxcell.pe.hu/rmxLineCmd.php";
    $url = "http://119.46.97.156/rmxline/rmxLineCmd.php";
    $response = post_web_content($url,$curl_data);
//^c^c
//New User
    print '<pre>';
    print_r($response);
    print_r("TEST");

   // echo "<script> location.href='http://rmxcell.pe.hu/frmLogin.php'; </script>";
    //exit;
    //http://rmxcell.pe.hu/frmLogin.php
    //open_web("http://rmxcell.pe.hu/frmLogin.php");
   // header("Location:rmxcell.pe.hu/frmLogin.php");
   //$response = file_get_contents('http://rmxcell.pe.hu/frmLogin.php?method=add_user&api_key=123&value=value1');
    

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
    return $content;
}

function open_web( $url)
{

    $ch = curl_init();

    // set URL and other appropriate options
    //curl_setopt($ch, CURLOPT_URL, "http://www.example.com/");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // grab URL and pass it to the browser
    curl_exec($ch);
    // close cURL resource, and free up system resources
    curl_close($ch);

}
?>
