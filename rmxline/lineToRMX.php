

<?php
/* 
https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/reply&token=m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=
&value={"replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/quota/consumption
https://api.line.me/v2/bot/message/delivery/reply?date={yyyyMMdd}
https://api.line.me/v2/bot/message/delivery/reply?date=20210915


https://rmxline.herokuapp.com/lineToRMX.php

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/push&value={"to":"@728ohvhl","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}


http://rmxcell.pe.hu/rmxLineCmd.php?LineId=t0000-930000330&CompanyCode=00001%20
&Command=call%20sp_comp_insert_user_resquest%20(%27test00948477444%27,%2700001%27,%27test%20send%20text%27,%27test%20send%20message%27);

*/
    ini_set('max_input_time','500');
    ini_set('max_execution_time','500'); 
    set_time_limit(300); 

  
    
    $urlLink='';
    if (isset($_GET['link'])) {
        $urlLink =$_GET['link'];
       // echo $urlLink;    
    } else {
        //$urlLink='http://rmxcell.pe.hu/rmxLineCmd.php';
	$urlLink='http://119.46.97.156/rmxline/rmxLineCmd.php';
   
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
    } else {
        $tokenlLink='m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=';
    }
    $tokenlLink=urlencode($tokenlLink);


    $command='';
    if (isset($_GET['command'])) {
        $command =$_GET['command'];
            
    } else {      
        $command= 'call sp_comp_insert_user_resquest (
                "test00948477www444"
                ,"00001"
                ,"eeee test send text"
                ,"www test send message");';
    }

    $command=urlencode($command);


    $data = http_build_query(array(
        "LineId"  => $tokenlLink,
        "CompanyCode" => $compId,
        "Command" => $command
        ));

    echo sendToRMX($urlLink, $compId,$data);

  
    function sendToRMX($url,$compId,$post) {
        try {

            header('Content-Type: multipart/form-data'); // Specify the type of data
            
            $ch = curl_init($url); // Initialise cURL
            
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

                        
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=utf-8' )); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            IF (strlen($post) >0) {
                curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST            
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
            }
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
            $result = curl_exec($ch); // Execute the cURL statement
            //echo $result;
            curl_close($ch); // Close the cURL connection
            return $result; // Return the received data
            //return json_decode($result); // Return the received data
        } catch(Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),E_USER_ERROR);
        
        }
     }


    

/*

    //https://rmxline.herokuapp.com?link=TESTTEST
    $json2 = '{
        "size":{
            "width":2500,
            "height":1686
        },
        "selected": false,
        "name": "LINE Developers Info",
        "chatBarText": "Tap to open",
        "areas": [
            {
                "bounds": {
                    "x": 34,
                    "y": 24,
                    "width": 169,
                    "height": 193
                },
                "action": {
                    "type": "uri",
                    "uri": "https://developers.line.biz/en/news/"
                }
            },
            {
                "bounds": {
                    "x": 229,
                    "y": 24,
                    "width": 207,
                    "height": 193
                },
                "action": {
                    "type": "uri",
                    "uri": "https://www.line-community.me/en/"
                }
            },
            {
                "bounds": {
                    "x": 461,
                    "y": 24,
                    "width": 173,
                    "height": 193
                },
                "action": {
                    "type": "uri",
                    "uri": "https://engineering.linecorp.com/en/blog/"
                }
            }
        ]
      }';

      $json='{        
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

        $toUser ='1656424703';
        $json='{
            "to": ["1656424703"],
            "messages":[
                {
                    "type":"text",
                    "text":"Hello, world1"
                },
                {
                    "type":"text",
                    "text":"Hello, world2"
                }
            ]
        }';

      $token3 = '{018b4e7d5bec3f10f94fa11e32692fc4}';
      $token ='m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=';
      
      //$url = 'https://api.line.me/v2/bot/richmenu';
      
      
      //$url = 'https://api.line.me/v2/bot/message/reply';
      $url = 'https://api.line.me/v2/bot/message';

      echo $url."\n\n".$post;
      echo richmenu_request($url,$token, $post);
    //echo httpPost("https://api.line.me/v2/bot/richmenu", $json);
    //echo jwt_request($url, $token,$json);
        //@728ohvhl
        //@728ohvhl
    $url1 = 'https://api.line.me/v2/bot/richmenu';
    $post1 ='{
        "size": {
            "width": 2500,
            "height": 1686
        },
        "selected": false,
        "name": "richmenu-b",
        "chatBarText": "Tap to open",
        "areas": [
            {
                "bounds": {
                    "x": 0,
                    "y": 0,
                    "width": 1250,
                    "height": 1686
                },
                "action": {
                    "type": "richmenuswitch",
                    "richMenuAliasId": "richmenu-alias-a",
                    "data": "richmenu-changed-to-a"
                }
            },
            {
                "bounds": {
                    "x": 1251,
                    "y": 0,
                    "width": 1250,
                    "height": 1686
                },
                "action": {
                    "type": "uri",
                    "uri": "https://www.line-community.me/"
                }
            }
        ]
    }';
*/
?>
