<?php


function getTicketFromDatabase($objParamFromUrl, $getDataFromDatabase)
{

    /*
    https://rmx.freewillsolutions.com/rmxline/rmxLineCmd.php?
    QueryCommand=call sp_comp_select_ticket('U379c8a7fce077a831d3fbfad3c1e4bda', '01/01/2017', '31/12/2022', '320001839')
    &LineId=U379c8a7fce077a831d3fbfad3c1e4bda
    &CompanyCode=00001
    */

    $objData = new stdClass;
    $RetCommand  = '';
    $LineId = $objParamFromUrl->LineId;
    $CompanyUrl =  $objParamFromUrl->CompanyUrl;
    $CompanyCode =  $objParamFromUrl->CompanyCode;
    $CmdCommand = $objParamFromUrl->CmdCommand;

    $sShipToCode =  $getDataFromDatabase->ShipToCode;

    // $RetCommand = sendQuery('Command', $CompanyUrl, '', '', $CmdCommand);
    // if ($RetCommand) {
    //     $ASRet = [];
    //     $ASRet = explode("^c", $RetCommand);
    //     if (count($ASRet) >= 2) {
    //         $sFlagMsg = $ASRet[0];
    //         $sFlag = $ASRet[1];
    //         if ($sFlag != '0') {
    //             //
    //             $dStartDate = '01/01/2017';
    //             $dEndDate = '31/12/2022';

    //             if ($sShipToCode == '') {
    //                 $LineId = 'Ucd102187a2dfb7494ea9d723a5ae4041';
    //                 $sShipToCode = '320000106';
    //             }

    //             $CmdCommand = "call sp_comp_select_ticket('$LineId','$dStartDate','$dEndDate','$sShipToCode')";
    //             $RetCommand = sendQuery('QueryCommand', $CompanyUrl, $LineId, $CompanyCode, $CmdCommand);
    //         }
    //     }
    // }
    //
    //
    $dStartDate = '01/01/2017';
    $dEndDate = strval(date("d/m/Y"));
    $CmdCommand = "call sp_comp_select_ticket('$LineId','$dStartDate','$dEndDate','$sShipToCode')";
    $RetCommand = sendQuery('QueryCommand', $CompanyUrl, $LineId, $CompanyCode, $CmdCommand);
    if ($RetCommand == '' || $RetCommand == 'No New/Update Data') {
        $LineId = 'Ucd102187a2dfb7494ea9d723a5ae4041';
        $sShipToCode = '320000106';
        $CmdCommand = "call sp_comp_select_ticket('$LineId','$dStartDate','$dEndDate','$sShipToCode')";
        $RetCommand = sendQuery('QueryCommand', $CompanyUrl, $LineId, $CompanyCode, $CmdCommand);
    }

    return  $RetCommand;
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