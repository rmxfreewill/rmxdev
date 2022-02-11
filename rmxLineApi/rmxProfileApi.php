<?php

error_reporting(-1);
ini_set('display_errors', 'On');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$GLOBALS['obj'] = new stdClass();

function rmxApiGetProfile($LineId)
{
    //
    $conn = mysqli_connect("127.0.0.1", "root", "freewill@kernel1168/86-88", "rmxmain", 3306);
    //

    if ($conn) {
        // if ($mobileNo != '') {
        //     $sql_mobile = " OR sMobileNo = '$mobileNo'";
        // } else {
        //     $sql_mobile = '';
        // }

        $sql = "SELECT * FROM m_user WHERE sLineId = '$LineId'";
        $result = $conn->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row) {
            $GLOBALS['obj']->name = $row["sName"];
            $GLOBALS['obj']->surname = $row["sSurName"];
            $GLOBALS['obj']->mobile = $row["sMobileNo"];
            $GLOBALS['obj']->email = $row["sEMail"];
            $GLOBALS['obj']->soldtocode = $row["sSoldToCode"];
            echo json_encode($GLOBALS['obj']);
        }
    }
}


function mySQLconnect($query)
{
    $conn = mysqli_connect("127.0.0.1", "root", "freewill@kernel1168/86-88", "rmxmain", 3306);
    $result = mysqli_query($conn, $query);
    return $result;
}

function rmxApiGetSoldToCode($lineId)
{
    $soldtocode = '';
    $sql = "SELECT * FROM m_user WHERE sLineId = '$lineId'";
    $result = mySQLconnect($sql);
    if ($result) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row) {
            $soldtocode = $row["sSoldToCode"];
        }
    }
    return $soldtocode;
}

function rmxApiGetAllLineId($soldtocode)
{
    $data = [];
    $sql = "SELECT sLineId FROM m_user WHERE sSoldToCode = '$soldtocode'";
    $result = mySQLconnect($sql);
    if ($result) {
        $numRow = mysqli_num_rows($result);
        if ($numRow) {
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                array_push($data, $row[0]);
            }
        }
    }
    return $data;
}

function rmxApiGetSoldToCodeAndLineId($lineId)
{
    $data = [];
    $soldtocode = '';
    $sql = "SELECT * FROM m_user WHERE sLineId = '$lineId'";
    $result = mySQLconnect($sql);
    if ($result) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row) {
            $soldtocode = $row["sSoldToCode"];
            $GLOBALS['obj']->soldtocode = $soldtocode;

            $sql = "SELECT sLineId FROM m_user WHERE sSoldToCode = '$soldtocode'";
            $result = mySQLconnect($sql);
            if ($result) {
                $numRow = mysqli_num_rows($result);
                if ($numRow) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
                        array_push($data, $row[0]);
                    }
                }
                $GLOBALS['obj']->lineid = $data;
            }
        }
    }
    echo json_encode($GLOBALS['obj']);
}
