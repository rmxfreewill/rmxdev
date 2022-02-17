<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include_once("zApiFunction.php");
include_once("zMenuFunction.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/rmxWebhookFunction.php");

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include("function/registerMenuFunc.php");

$GLOBALS['COMPANY_CODE'] =   COMPANY_CODE;

$sFlag = '';
$regisType = false;

$getDataFromUrl = getDataFromUrlv2();
$status = $getDataFromUrl->status;

if ($status == 'check') {
    registerDataToDatabase($getDataFromUrl);
}

$getData = getDataFromDatabase($getDataFromUrl);
$sFlag = $getData->sFlag;

if ($sFlag == '4') {
    $LINEID = $getDataFromUrl->LineId;
    rmxChangeMemberRichMenu('MEMBER', $LINEID);
}

?>
<!DOCTYPE HTML>
<html>

<body>
    <div class="col-12 mb-3 mt-3">
        <h3>Register</h3>
    </div>
    <div class="col-12 mb-3">
        <?php
        echo regisForm($regisType);
        ?>
    </div>
    <script>
        $(function() {
            var sFlag = "<?php echo $sFlag; ?>";
            if (sFlag != '') {
                $("#rmxLoader").hide();
            } else if (sFlag == '4') {
                rmxCloseWindow();
            }
        });
    </script>
</body>

</html>

<!-- var urlS = new URL(document.URL); -->