<?php
/*    include_once("index.html"); */

session_start();

$nameText = '';
$mobileText = '';
$emailText = '';
$LineId = '';
if (isset($_POST['LineId'])) {
    $LineId = $_POST['LineId'];
}
if (isset($_GET['LineId'])) {
    $LineId = $_GET['LineId'];
}


echo $LineId;


?>

<div class="container mt-5">
    <div class="card border-success">
        <div class="card text-white">
            <h4 class="card-header bg-success text-uppercase font-weight-bold">user profile</h4>
            <div class="card-body text-dark" style="background-color:#ebf7f0;">
                <h5>
                    <!-- <div class="row card-text"> -->
                    <!-- <div class="col-5 text-uppercase font-weight-bold">
                                name
                            </div> -->
                    <!-- <div class="col-7 font-weight-normal"> -->
                    <?php
                    // echo $nameText;
                    ?>
                    <!-- </div> -->
                    <!-- </div> -->
                    <div class="row card-text mt-3">
                        <div class="col-5 text-uppercase font-weight-bold">
                            mobile no
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php

                            ?>
                        </div>
                    </div>
                    <div class="row card-text mt-3">
                        <div class="col-5 text-uppercase font-weight-bold">
                            email
                        </div>
                        <div class="col-7 font-weight-normal">
                            <?php

                            ?>
                        </div>
                    </div>
                </h5>
            </div>
        </div>
    </div>
</div>
<script>
    $("#rmxLiFFLayout").hide();
</script>