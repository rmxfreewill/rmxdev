<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include("function/globalMenuFunc.php");
include("function/registerMenuFunc.php");

$sFlag = '';
$regisType = false;

$getDataFromUrl = getDataFromUrl();
$LineId = $getDataFromUrl->LineId;
$status = $getDataFromUrl->status;
if ($status == 'check') {
    registerDataToDatabase($getDataFromUrl);
}
$getData = getDataFromDatabase($getDataFromUrl);
$sFlag = $getData->sFlag;
if ($sFlag == '4') {
    // rmxChangeRichMenu('MEMBER', $LineId);
    echo 'ChangeMenu';
} else {
?>
    <div class="m-3 bg-white shadow bg-white rounded">
        <div class="p-4">
            <div class="col-12 text-center">
                <h2>Register</h2>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label for="psw" class="form-label form-label-lg"><b>Email</b></label>
                    <input type="email" class="form-control form-control-lg" id="txtEMail" name="txtEMail" placeholder="Enter EMail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" maxlength="40" required>
                </div>
                <div class="mb-4">
                    <label for="psw" class="form-label form-label-lg"><b>Mobile</b></label>
                    <input type="tel" class="form-control form-control-lg" placeholder="Enter Mobile" name="txtTel" id="txtTel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" maxlength="10" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success btn-lg pt-3 pb-3 fw-bold rmxRegisterButton" type="button" name="btnLogin" id="btnLogin" onclick="registerCheck('aa','aa')">REGISTER</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function registerCheck(sUrl, userIdProfile) {
            var sUserName = 'rmxadmin';
            var sLineDisplay = 'rmxadmin';
            //
            var sCompanyCode = "00001";
            var sEMail = document.getElementById('txtEMail').value;
            //
            var sTel = document.getElementById('txtTel').value;
            if (sTel == '') {
                alert("Input Telephone / Mobile");
            } else if (sEMail == '') {
                alert("Input Email");
            } else {
                if (sTel.length < 8) {
                    alert("Telephone / Mobile must be at least 8 digits long");
                } else {
                    var toMenu = 'register';
                    var toStatus = 'check';
                    var sCmd = sLineDisplay + "^c" + sUserName + "^c" + sTel + "^c" + sEMail;
                    var urlSelectMenu = rmxSelectMenu(sUrl, toMenu, userIdProfile, sCmd, toStatus);
                    var param = urlSelectMenu.paramS;
                    var menuUrl = "menu/registerMenu.php" + param;
                    alert(menuUrl);
                    $("#rmxLiFFLayout").load(menuUrl);
                }
            }
        }

        $(function() {
            alert("<?php echo sURL; ?>");
            alert("<?php echo  $LineId; ?>");
            var sFlag = "<?php echo $sFlag; ?>";
            if (sFlag != '') {
                $("#rmxLoader").hide();
            } else if (sFlag == '4') {
                rmxCloseWindow();
            }
        });
    </script>

<?php
}
?>


<!-- var urlS = new URL(document.URL); -->