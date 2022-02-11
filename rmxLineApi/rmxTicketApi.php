<?php


include_once("rmxProfileApi.php");


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$GLOBALS['obj'] = new stdClass();

function rmxApiGetTicketDetails($lineId)
{
    $data = [];

    $soldToCode = rmxApiGetSoldToCode($lineId);
    $sql = "SELECT 
    sTicketNo,sProductCode,dTicketDate,dTicketTime,sCompanyName,
    sSoldToName,sShipToPerson,sShipToMobile,sShipToName,dLoadDate,
    dLoadTime,dLeaveDate,dLeaveTime,dDeliveryDate,dDeliveryTime,
    sTruckNo,sDriverName,nOrderQty,sPlantCode,sProductName,
    sSlump,sStrength,sSpecialInstruction 
    FROM rmx01.T_LineTicket INNER JOIN rmxmain.M_User ON rmx01.T_LineTicket.sSoldToCode = rmxmain.M_User.sSoldToCode 
    WHERE rmx01.T_LineTicket.sSoldToCode = '$soldToCode' AND rmx01.T_LineTicket.nLineNoti = 0  
    GROUP BY rmx01.T_LineTicket.sTicketNo ORDER BY rmx01.T_LineTicket.sTicketNo DESC LIMIT 1";
    
    $result = mySQLconnect($sql);
    if ($result) {
        $numRow = mysqli_num_rows($result);
        if ($numRow) {
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) { //23 Field
                $data_sub = array();
                array_push($data_sub, $row[0]);
                array_push($data_sub, $row[1]);
                array_push($data_sub, $row[2]);
                array_push($data_sub, $row[3]);
                array_push($data_sub, $row[4]);
                array_push($data_sub, $row[5]);
                array_push($data_sub, $row[6]);
                array_push($data_sub, $row[7]);
                array_push($data_sub, $row[8]);
                array_push($data_sub, $row[9]);
                array_push($data_sub, $row[10]);
                array_push($data_sub, $row[11]);
                array_push($data_sub, $row[12]);
                array_push($data_sub, $row[13]);
                array_push($data_sub, $row[14]);
                array_push($data_sub, $row[15]);
                array_push($data_sub, $row[16]);
                array_push($data_sub, $row[17]);
                array_push($data_sub, $row[18]);
                array_push($data_sub, $row[19]);
                array_push($data_sub, $row[20]);
                array_push($data_sub, $row[21]);
                array_push($data_sub, $row[22]);
            }
            array_push($data, $data_sub);
        }
        mysqli_free_result($result);
        echo json_encode($data);
    }
}
