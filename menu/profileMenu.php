<?php
/*    include_once("index.html"); */

error_reporting(-1);
ini_set('display_errors', 'On');

include_once("zApiFunction.php");
include_once("zMenuFunction.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");


$getDataFromUrl = getDataFromUrlv2();
$LineId = $getDataFromUrl->LineId;

try {
    $getData = getDataFromDatabase($getDataFromUrl);
    $sFlag = $getData->sFlag;
    $nameText = $getData->UserName;
    $mobileText = $getData->Tel;
    $emailText = $getData->EMail;
} catch (\Throwable $th) {
    $nameText = '';
    $mobileText = '';
    $emailText = '';
}

?>

<div class="container mt-5">
    <div class="card border-success">
        <div class="card text-white">
            <h4 class="card-header bg-success text-uppercase font-weight-bold">user profile</h4>
            <div class="card-body text-dark" style="background-color:#ebf7f0;">
                <h5>
                    <div class="row card-text">
                        <div class="col-5 text-uppercase font-weight-bold">
                            LineID
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php
                            echo $LineId;
                            ?>
                        </div>
                    </div>
                    <div class="row card-text">
                        <div class="col-5 text-uppercase font-weight-bold">
                            Name
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php
                            echo $nameText;
                            ?>
                        </div>
                    </div>
                    <div class="row card-text mt-3">
                        <div class="col-5 text-uppercase font-weight-bold">
                            Mobile no
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php
                            echo $mobileText;
                            ?>
                        </div>
                    </div>
                    <div class="row card-text mt-3">
                        <div class="col-5 text-uppercase font-weight-bold">
                            Email
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php
                            echo $emailText;
                            ?>
                        </div>
                    </div>
                </h5>
            </div>
        </div>
    </div>
</div>
<script>
    $(".loader").hide();
</script>