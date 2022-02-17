<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include("function/globalMenuFunc.php");
include("function/registerMenuFunc.php");

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
    // rmxChangeRichMenu('MEMBER', $LINEID);
    echo 'ChangeMenu';
} else {
    echo 'RegisForm';
}

?>
<div class="mb-3 mt-3 bg-white shadow-sm p-3 mb-5 bg-white rounded">
    <div class="col-12 text-center">
        <h3>Register</h3>
    </div>
    <div class="col-12 p-3">
        <?php
        echo regisForm($regisType);
        ?>
    </div>
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


<!-- var urlS = new URL(document.URL); -->