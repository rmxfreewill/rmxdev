<?php
/*    include_once("index.html"); */

error_reporting(-1);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include("function/globalMenuFunc.php");

$getDataFromUrl = getDataFromUrl();
$LineId = $getDataFromUrl->LineId;

try {
    $getData = getDataFromDatabase($getDataFromUrl);
    $sFlag = $getData->sFlag;
    $nameText = $getData->UserName;
    $mobileText = $getData->Tel;
    $emailText = $getData->EMail;
    $soldToNameText = $getData->SoldToName;
    $shipToNameText = $getData->ShipToName;
} catch (\Throwable $th) {
    $nameText = '';
    $mobileText = '';
    $emailText = '';
    $soldToNameText = '';
    $shipToNameText = '';
}

?>

<div class="m-3 bg-white shadow bg-white rounded" id="regisForm">
    <div class="p-4">
        <div class="col-12 text-center">
            <h2>Profile</h2>
        </div>
        <div class="col-12 m-3">
            <div class="row">
                <label class="col-sm-2 col-form-label col-form-label-lg">Name</label>
                <input type="input" class="form-control form-control-lg" id="nameText" value="<?php echo $nameText == '' ?? '-'; ?>" readonly>
                <label class="col-sm-2 col-form-label col-form-label-lg">Mobile</label>
                <input type="input" class="form-control form-control-lg" id="mobileText" value="<?php echo $mobileText; ?>" readonly>
                <label class="col-sm-2 col-form-label col-form-label-lg">SoldToName</label>
                <input type="input" class="form-control form-control-lg" id="soldToNameText" value="<?php echo $soldToNameText; ?>" readonly>
                <label class="col-sm-2 col-form-label col-form-label-lg">ShipToName</label>
                <input type="input" class="form-control form-control-lg" id="shipToNameText" value="<?php echo $shipToNameText; ?>" readonly>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 hidden">
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