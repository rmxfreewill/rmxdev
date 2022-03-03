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

function showTicketList($RetCommand)
{
    if ($RetCommand) {
        $asTable = explode("^t", $RetCommand);
        if (count($asTable) > 0) {
            $arTmp = explode("^f", $asTable[0]);
            echo 'arTmp: ' . json_encode($arTmp);
            if (count($arTmp) > 1) {
                $asCol = explode("^c", $arTmp[0]);
                $asRow = explode("^r", $arTmp[1]);
                if (count($asRow) > 0) {
                    $nLoop = 0;
                    $nRLen = count($asRow);
                    $nCLen = count($asCol);
                    $sTab = "";
                    $sPage = "";
                    if ($nRLen > 10) $nRLen = 10;

                    for ($n = 0; $n < $nRLen; $n++) {
                        $sRow = $asRow[$n];
                        echo 'sRow: ' . json_encode($sRow);
                        // $asData = explode("^c", $sRow);
                        // $nDLen = count($asData);
                        // if ($nDLen > 0) {
                        //     $sTicketNo = $asData[0];
                        //     $sTab = $sTab . "<a class='tablink' href='#' "
                        //         . "onclick=\"openPage('div" . $sTicketNo . "_" .
                        //         "', this, 'red')\">" . $sTicketNo . "</a>";

                        //     $sPage = $sPage . "<div id='div" . $sTicketNo . "_" .
                        //         "' class='tabcontent'>";
                        //     $sPage = $sPage . "<table class='tblticket'>";

                        //     for ($r = 0; $r < $nDLen; $r++) {
                        //         $sC = $asCol[$r];
                        //         $sD = $asData[$r];

                        //         $sPage = $sPage . "<tr><th>" . $sC
                        //             . "</th><td class='textLeft'>" . $sD . "</td></tr>";
                        //     }
                        //     $sPage = $sPage . "</table></div>";
                        // }
                    }

                    // $sTab = "<div class='scrollmenu'>" . $sTab . "</div>";
                    // echo $sTab;
                    // echo $sPage;
                }
            }
        }
    }
}
