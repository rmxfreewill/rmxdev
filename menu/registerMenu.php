<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include("function/globalMenuFunc.php");
include("function/registerMenuFunc.php");


$GLOBALS['RICHMENU_ID'] =  RICHMENU_ID;
$GLOBALS['BEARER_TOKEN'] =  BEARER_TOKEN;
$GLOBALS['COMPANY_CODE'] =   COMPANY_CODE;

$sFlag = '';
$regisType = false;

$getDataFromUrl = getDataFromUrl();
$status = $getDataFromUrl->status;

if ($status == 'check') {
    registerDataToDatabase($getDataFromUrl);
}

$getData = getDataFromDatabase($getDataFromUrl);
$sFlag = $getData->sFlag;

if ($sFlag == '4') {
    $LINEID = $getDataFromUrl->LineId;
    rmxChangeRichMenu('MEMBER', $LINEID);
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