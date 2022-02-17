<?php

function registerDataToDatabase($objParam)
{
    $objData = new stdClass;

    $RegisterUrl = $objParam->RegisterUrl;
    $LineId = $objParam->LineId;
    $CompanyCode =  $objParam->CompanyCode;
    $CmdCommand = $objParam->CmdCommand;

    $ASRet = [];
    $ASRet = explode("^c", $CmdCommand);
    $LineDisplay = $ASRet[0];
    $UserName = $ASRet[1];
    $Tel = $ASRet[2];
    $EMail = $ASRet[3];

    // sp_comp_reqister_user ('Uc1dd5c7730988280c6c7731980655f7a','00001','rmxadmin','111','111','111','111','111','111');

    // `sp_comp_reqister_user`(
    //     IN $sLineId VARCHAR(50) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sCompanyCode VARCHAR(50) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sUserName VARCHAR(300) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sSoldToCode VARCHAR(100) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sSoldToName VARCHAR(300) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sShipToCode VARCHAR(100) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sShipToName VARCHAR(300) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sMobileNo VARCHAR(100) CHARACTER SET UTF8 COLLATE utf8_unicode_ci
    //     ,IN $sEMail VARCHAR(100) CHARACTER SET UTF8 COLLATE utf8_unicode_ci



    $curl_data = "LineId=" . $LineId . "&CompanyCode=" . $CompanyCode
    . "&LineDisplay=" . $LineDisplay . "&UserName=" . $UserName
    . "&Tel=" . $Tel . "&EMail=" . $EMail;

    $RetCommand = postWebContent($RegisterUrl, $curl_data);

    if ($RetCommand) {
        $ASRet = [];
        $ASRet = explode("^c", $RetCommand);
        if (count($ASRet) >= 5) {

            $sFlagMsg = $ASRet[0];
            $sFlag = $ASRet[1];
            $UserName = $ASRet[2];
            $Tel = $ASRet[3];
            $EMail = $ASRet[4];
            $SoldToCode = $ASRet[5];
            $SoldToName = $ASRet[6];

            $sShowMsg = '1';
            if ($sFlag == '4') {
                $sFlag = '5';
                $sFlagMsg = "Register Complete";
            }
        }
        $objData->RetCommand = $RetCommand;
        $objData->sFlag = $sFlag;
    } else {
        $objData->sFlag = '0';
    }
    return $objData;
}

function regisForm($type)
{
    $arr[0] = '';
    $arr[1] = '';
    if ($type == true) {
        $regisForm = '
        <div class="mb-3">
        <label for="psw"><b>Email: </b></label>' . $arr[0] . '
        <p><label for="psw"><b>Mobile: </b></label>' . $arr[1] . '
        <p><button type="button"  name="btnLogin" id="btnLogin" onclick="closeClick()">
            CLOSE
        </button>
        </div>
        ';
    } else {
        $regisForm = '
        <div class="mb-3">
        <label for="psw" class="form-label form-label-lg"><b>Email</b></label>
        <input type="email" class="form-control form-control-lg"
            id="txtEMail" 
            name="txtEMail"
            placeholder="Enter EMail"
            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            maxlength="40"
        required>
        </div>
        <div class="mb-3">
        <label for="psw" class="form-label form-label-lg"><b>Mobile</b></label>
        <input type="tel" class="form-control form-control-lg"
            placeholder="Enter Mobile" 
            name="txtTel" id="txtTel" 
            pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" 
            maxlength="10"
        required>
        </div>
        <div class="mb-3">
        <button class="btn btn-success btn-lg rmxRegister pt-3 pb-3" type="button"  
            name="btnLogin" 
            id="btnLogin" 
            onclick="registerCheck()"
        >
        REGISTER
        </button>
        </div>
        ';
    }
    return $regisForm;
}


?>