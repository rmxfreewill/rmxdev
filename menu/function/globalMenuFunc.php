<?php




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


function sendQuery($type, $CompanyUrl, $userId, $CompanyId, $Command)
{
    if ($type = 'Command') {
        $curlCmd = "&Command=" . $Command;
    } else if ($type = 'QueryCommand') {
        $curlCmd = "&QueryCommand=" . $Command;
    }

    $curl_data = "LineId=" . $userId . "&CompanyCode=" . $CompanyId . $curlCmd;
    $response = postWebContent($CompanyUrl, $curl_data);
    return $response;
}

function getDataFromUrl()
{
    $objData = new stdClass;

    $menu = '';
    if (isset($_POST['menu']))
        $menu = $_POST['menu'];
    if (isset($_GET['menu']))
        $menu = $_GET['menu'];

    $status = '';
    if (isset($_POST['status']))
        $status = $_POST['status'];
    if (isset($_GET['status']))
        $status = $_GET['status'];

    $LineId = '';
    if (isset($_POST['LineId']))
        $LineId = $_POST['LineId'];
    if (isset($_GET['LineId']))
        $LineId = $_GET['LineId'];

    $CmdCommand = '';
    if (isset($_POST['CmdCommand']))
        $CmdCommand = $_POST['CmdCommand'];
    if (isset($_GET['CmdCommand']))
        $CmdCommand = $_GET['CmdCommand'];

    $LineDisplay = '';
    $UserName = '';
    $sSoldToCode = '';
    $sSoldToName = '';
    $Tel = '';
    $EMail = '';


    if ($status == 'check') {
    } else {
        $CmdCommand = "call sp_main_check_register ('" . $LineId . "','" .  $GLOBALS['COMPANY_CODE'] . "')";
    }

    $objData->menu = $menu;
    $objData->status = $status;
    $objData->LineId = $LineId;
    $objData->CompanyUrl = $GLOBALS['COMPANY_URL'];
    $objData->CompanyCode = $GLOBALS['COMPANY_CODE'];
    $objData->RegisterUrl = $GLOBALS['REGISTER_URL'];
    $objData->CmdCommand = $CmdCommand;



    return $objData;
}

function getDataFromDatabase($objParam)
{
    //select $sFlagMsg,$nFlag,$sTUserName,$sTEMail,$sTMobileNo;
    // echo json_encode('CmdCommand: ' . $objParam);
    $objData = new stdClass;

    $CompanyUrl = $GLOBALS['COMPANY_URL'];

    $CmdCommand = $objParam->CmdCommand;
    $RetCommand = sendQuery(
        'Command',
        $CompanyUrl,
        '',
        '',
        $CmdCommand
    );


    try {
        $objData->status = 200;
        if ($RetCommand) {
            $ASRet = [];
            $ASRet = explode("^c", $RetCommand);
            if (count($ASRet) >= 2) {
                $sFlagMsg = $ASRet[0];
                $sFlag = $ASRet[1];
                $UserName = $ASRet[2];
                $EMail = $ASRet[3];
                $Tel = $ASRet[4];
                $SoldToCode = $ASRet[5];
                $SoldToName = $ASRet[6];
                $ShipToCode = $ASRet[7];
                $ShipToName = $ASRet[8];

                $objData->UserName = $UserName;
                $objData->EMail = $EMail;
                $objData->Tel = $Tel;
                $objData->SoldToCode = $SoldToCode;
                $objData->SoldToName = $SoldToName;
                $objData->ShipToCode = $ShipToCode;
                $objData->ShipToName = $ShipToName;
                $objData->sFlag = $sFlag;
            }
        } else {
            $objData->sFlag = '0';
        }
        $objData->RetCommand = $RetCommand;
    } catch (\Throwable $th) {
        $objData->sFlag = '0';
        $objData->status = $th;
    }
    $objData->LineId = $objParam->LineId;

    return $objData;
}

function rmxChangeRichMenu($type, $LINEID)
{
    if ($type == 'LOGOUT') {
        $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu";
        $method = 'DELETE';
    } else if ($type == 'MEMBER') {
        $CURLOPT = CURLOPT_POST;
        $RICHMENUID = $GLOBALS['RICHMENU_ID'];
        $url = "https://api.line.me/v2/bot/user/$LINEID/richmenu/$RICHMENUID";
        $method = "POST";
    }
    $data = array();
    $headers = [
        "Authorization: Bearer " . $GLOBALS['BEARER_TOKEN']
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
