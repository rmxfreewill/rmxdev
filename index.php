<?php

session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

include("define_Global.php");
include("menu/function/globalMenuFunc.php");

$getDataFromUrl = getDataFromUrl();
$menu = $getDataFromUrl->menu;
$LineId = $getDataFromUrl->LineId;
$getData = getDataFromDatabase($getDataFromUrl);
$sFlag = $getData->sFlag;

// echo "flag: " . $sFlag;
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>RMX LINE OFFICIAL</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="en-th">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/ticket_style.css">
    <link rel="stylesheet" href="css/search_style.css">
    <link rel="stylesheet" href="css/bootstrap.css">

    <script charset="utf-8" src="js/jquery.js"></script>
    <script charset="utf-8" src="js/popper.min.js"></script>
    <script charset="utf-8" src="js/bootstrap.js"></script>
    <script charset="utf-8" src="js/lineSdk_2_18_1.js"></script>
    <script charset="utf-8" src="js/rmx_liff_function.js"></script>
</head>

<body class="rmxbody">
    <div class="loader" id="rmxLoader"></div>
    <div class="container">
        <div class="row">
            <div id="rmxLiFFLayout"></div>
        </div>
    </div>
    <script>
        async function rmxInitializeLineLiff(myLiffId = String) {
            await liff.init({
                    liffId: myLiffId
                })
                .then(() => {
                    if (liff.isLoggedIn()) {
                        liff.getProfile()
                            .then(profile => {
                                const userIdProfile = profile.userId;
                                const sCompCode = "<? echo COMPANY_CODE; ?>";
                                const sUrl = "<? echo sURL; ?>";
                                const sFlag = "<? echo $sFlag; ?>";
                                var getParam = rmxGetParams();
                                var toMenu = getParam.menu;
                                var toCmd = getParam.CmdCommand;
                                var toStatus = getParam.status != null ? getParam.status : 'init';
                                var urlSelectMenu = rmxSelectMenu(sUrl, toMenu, userIdProfile, toCmd, toStatus);
                                var menuUrl = urlSelectMenu.menuUrl;
                                var paramS = urlSelectMenu.paramS;

                                // if (toMenu == "register") {
                                //     menuUrl = "menu/registerMenu.php" + paramS;
                                // }
                                
                                alert(toStatus);
                                if (sFlag == "4") {
                                    if (toMenu == "ticket") {
                                        menuUrl = "menu/ticketMenu.php" + paramS;
                                    } else if (toMenu == "profile") {
                                        menuUrl = "menu/profileMenu.php" + paramS;
                                    } else if (toMenu == "search") {
                                        menuUrl = "menu/searchMenu.php" + paramS;
                                    } else if (toMenu == "register") {
                                        <?php
                                        if ($menu == "register" && $sFlag == "4") {
                                            rmxChangeRichMenu('MEMBER', $LineId);
                                        }
                                        ?>
                                        rmxCloseWindow();
                                    }
                                } else if (sFlag == "0") {
                                    menuUrl = "menu/registerMenu.php" + paramS;
                                    <?php
                                    if ($sFlag == "0") {
                                        rmxChangeRichMenu('LOGOUT', $LineId);
                                    }
                                    ?>
                                }
                                alert(sFlag);
                                alert(menuUrl);
                                if (toStatus == 'init' || toStatus == 'check') {
                                    try {
                                        $("#rmxLiFFLayout").load(menuUrl);
                                    } catch (err) {
                                        console.log('err rmxLiFFLayout: ' + error);
                                    }
                                }
                            })
                            .catch((err) => {
                                console.log('err getProfile: ', err);
                            });
                    }
                })
                .catch((err) => {
                    console.log('err initializeLiff: ', err);
                });
        }

        $(function() {
            var myLiffId = "<? echo LIFF_ID; ?>";
            rmxInitializeLineLiff(myLiffId);
        });
    </script>
</body>

</html>