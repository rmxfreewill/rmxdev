<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include_once("zApiFunction.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");

$GLOBALS['COMPANY_URL'] =  COMPANY_URL;
$GLOBALS['REGISTER_URL'] =   REGISTER_URL;
$GLOBALS['COMPANY_CODE'] =   COMPANY_CODE;
$GLOBALS['COMPANY_URL'] =   COMPANY_URL;
$GLOBALS['LIFF_ID'] =   LIFF_ID;
$GLOBALS['sURL'] =   sURL;


// include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
// include($_SERVER['DOCUMENT_ROOT'] . "/rmxLineFunction.php");

// function sendCommand($CompanyUrl, $userId, $CompanyId, $Command)
// {

//     $curl_data = "LineId=" . $userId . "&CompanyCode=" . $CompanyId . "&Command=" . $Command;
//     $response = post_web_content($CompanyUrl, $curl_data);
//     return $response;
// }








function getDataFromUrlv1($CompanyCode, $CompanyUrl, $RegisterUrl)
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
        $CmdCommand = "call sp_main_check_register ('" . $LineId . "','" . $CompanyCode . "')";
    }



    $objData->menu = $menu;
    $objData->status = $status;
    $objData->LineId = $LineId;
    $objData->CompanyUrl = $CompanyUrl;
    $objData->CompanyCode = $CompanyCode;
    $objData->RegisterUrl = $RegisterUrl;
    $objData->CmdCommand = $CmdCommand;



    return $objData;
}









function getSearchFromDatabase($objParam)
{
    $objData = new stdClass;
    $RetCommand  = '';
    $LineId = $objParam->LineId;
    $CompanyUrl =  $objParam->CompanyUrl;
    $CompanyCode =  $objParam->CompanyCode;
    $CmdCommand = $objParam->CmdCommand;
    $RetCommand = sendQuery('Command', $CompanyUrl, '', '', $CmdCommand);
    if ($RetCommand) { //select $sFlagMsg,$nFlag,$sTUserName,$sTEMail,$sTMobileNo;
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


            $sShowMsg = '0';
            if ($sFlag != '0') $sTitle = 'Search';
        }
    }
}


