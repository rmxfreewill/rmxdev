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