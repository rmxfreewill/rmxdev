<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include("function/globalMenuFunc.php");
include("function/registerMenuFunc.php");

$sFlag = '';
$getDataFromUrl = getDataFromUrl();
$LineId = $getDataFromUrl->LineId;
$status = $getDataFromUrl->status;
if ($status == 'check') {
    registerDataToDatabase($getDataFromUrl);
} else {
    $getData = getDataFromDatabase($getDataFromUrl);
    $sFlag = $getData->sFlag;
}

?>
<div class="m-3 bg-white shadow bg-white rounded" id="regisForm" hidden>
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
                <button class="btn btn-success btn-lg pt-3 pb-3 fw-bold rmxRegisterButton" type="button" name="btnLogin" id="btnLogin" onclick="registerButton()">REGISTER</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function registerButton() {
        $("#rmxLoader").show();
        var sUrl = "<?php echo sURL; ?>";
        var userIdProfile = "<?php echo  $LineId; ?>";
        await registerCheck(sUrl, userIdProfile);
    }

    $(function() {
        var sUrl = "<?php echo sURL; ?>";
        var sStatus = "<?php echo $status; ?>";
        if (sStatus == 'check') {
            location.assign(sUrl + "?menu=register");
        }

        var sFlag = "<?php echo $sFlag; ?>";
        if (sFlag != '') {
            $("#regisForm").removeAttr("hidden");
            $("#rmxLoader").hide();
        } else if (sFlag == '4') {
            <?php rmxChangeRichMenu('MEMBER', $LineId); ?>
            if (liff.getOS() != "web") {
                liff.closeWindow();
            }
        }
    });
</script>


<!-- var urlS = new URL(document.URL); -->