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
    $soldToCodeText = $getData->SoldToCode;
    $shipToCodeText = $getData->ShipToCode;

    if ($nameText == '') {
        $nameText = '-';
    }
} catch (\Throwable $th) {
    $nameText = '';
    $mobileText = '';
    $emailText = '';
    $soldToNameText = '';
    $shipToNameText = '';
    $soldToCodeText = '';
    $shipToCodeText = '';
}

?>

<div class="m-3 bg-white shadow bg-white rounded" id="regisForm">
    <div class="p-4">
        <div class="col-12 text-center">
            <h2>Profile</h2>
        </div>
        <div class="col-12 m-3">
            <div class="row">
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">LineId</label>
                <input type="input" class="form-control form-control-lg" id="LineIdText" value="<?php echo $LineId; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">Name</label>
                <input type="input" class="form-control form-control-lg" id="nameText" value="<?php echo $nameText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">Mobile</label>
                <input type="input" class="form-control form-control-lg" id="mobileText" value="<?php echo $mobileText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">Email</label>
                <input type="input" class="form-control form-control-lg" id="emailText" value="<?php echo $emailText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">SoldToName</label>
                <input type="input" class="form-control form-control-lg" id="soldToNameText" value="<?php echo $soldToNameText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg  text-secondary">ShipToName</label>
                <input type="input" class="form-control form-control-lg" id="shipToNameText" value="<?php echo $shipToNameText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg text-secondary">SoldToCode</label>
                <input type="input" class="form-control form-control-lg" id="soldToCodeText" value="<?php echo $soldToCodeText; ?>" disabled>
                <label class="col-sm-2 col-form-label col-form-label-lg  text-secondaryy">ShipToCode</label>
                <input type="input" class="form-control form-control-lg " id="shipToCodeText" value="<?php echo $shipToCodeText; ?>" disabled>
                <button class="btn btn-outline-danger btn-lg mt-3" type="button" id="btnLogout" onclick="checkLogout('profileMenu')">Logout</button>
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
    function checkLogout(menu) {
        if (menu == 'profileMenu') {
            <?php
            //rmxChangeRichMenu('LOGOUT', $LineId);
            ?>
        }
        rmxCloseWindow();
    }

    $(function() {
        $(".loader").hide();
    });
</script>