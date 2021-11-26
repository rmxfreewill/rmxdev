

<?php
/* 
https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/reply&token=m5ukw4jmYNNVqyIdVyXGQc1qdKqJSFxVCPpxfQRvYvRLXhn2+JvY+0uLU1inncWInYmDka3KYqBH/i3zfFq3oNHIAUnO7DXYu+3iIbzWp0eft69ZrxVv6qEDblNHVhlCRAWX6/Gkm//7h8yY0kX7XwdB04t89/1O/w1cDnyilFU=
&value={"replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA","messages":[{"type":"text","text":"Hello, user"},{"type":"text","text":"May I help you?"}]}

https://rmxline.herokuapp.com/?link=https://api.line.me/v2/bot/message/quota/consumption
https://api.line.me/v2/bot/message/delivery/reply?date={yyyyMMdd}
https://api.line.me/v2/bot/message/delivery/reply?date=20210915

https://rmxline.herokuapp.com/lineReply.php

*/
    ini_set('max_input_time','500');
    ini_set('max_execution_time','500'); 
    set_time_limit(300); 

    $urlLink='';
    if (isset($_GET['link'])) {
        $urlLink =$_GET['link'];
       // echo $urlLink;    
    } else {
        $urlLink='https://api.line.me/v2/bot/message/reply';
    }
    //id=@728ohvhl
   


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
        /* 
        $jsonLink= '{
            "replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
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
        */
    }

    echo jwt_request($urlLink, $tokenlLink,$jsonLink);

  
    function jwt_request($url,$token, $post) {
        try {
            header('Content-Type: application/json'); // Specify the type of data
            $ch = curl_init($url); // Initialise cURL
            
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            
            $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' 
                , $authorization )); // Inject the token into the header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            IF (strlen($post) >0) {
                $post = json_encode($post); // Encode the data array into a JSON string
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


       //echo richmenu_request($url1,$token, $post1);

    function richmenu_request($url,$token, $post) {


        try {
            header('Content-Type: application/json'); // Specify the type of data
            $ch = curl_init($url); // Initialise cURL
            
            if (FALSE === $ch)
                throw new Exception('failed to initialize');

            $post = json_encode($post); // Encode the data array into a JSON string
            $authorization = "Authorization: Bearer ".$token; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' 
                , $authorization )); // Inject the token into the header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
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


     

	function selectManyQuery($SQL,$HOST,$PORT,$USER,$PASS,$DB) {

        //echo '['.$SQL.']';
        //https://api.line.me/v2/bot/richmenuโดยกำหนด Headers และ Body ดังนี้


        $lconn=db_mainconnect($HOST,$USER,$PASS,$DB,$PORT);
        /* ----------------------------------------------------------*/     
        //echo $SQL;
        $lresult = db_query($lconn,$SQL);
        if ($lresult) {
            $fieldCount = mysqli_num_fields($lresult);    
            $res = "";
            //echo '['.$SQL.']='.$fieldCount.']';
            
            while($row = mysqli_fetch_array($lresult,MYSQLI_NUM)) { 

                if (strlen($res) >0) $res = $res."^r";
                for ($n=0;$n<$fieldCount;$n++) {
                    if ($n >0) $res=$res."^c";
                    $res=$res.trim($row[$n]);				
                }
            } 
            db_free($lresult);
            $lresult = null;

            echo $res;
        }	
        if ($lconn) {
            db_close($lconn);
        }
        $lconn = null;  
            /*

			$res = '';
            $res = db_multi_query($conn,$SQL);
            echo '['.$res.']';
			echoData($res);
			if ($conn) {
				mysqli_close($conn);
			}
			$conn = null;
            */
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
