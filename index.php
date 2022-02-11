<?php

session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

include("define_Global.php");
include("menu/zApiFunction.php");
include("menu/zMenuFunction.php");

include_once("rmxLineFunction.php");

// header('Access-Control-Allow-Origin: *');

$GLOBALS['COMPANY_URL'] =  COMPANY_URL;
$GLOBALS['REGISTER_URL'] =   REGISTER_URL;
$GLOBALS['COMPANY_CODE'] =   COMPANY_CODE;
$GLOBALS['LIFF_ID'] =   LIFF_ID;
$GLOBALS['sURL'] =   sURL;

$Function = '';
if (isset($_POST['Function']))
    $Function = $_POST['Function'];
if (isset($_GET['Function']))
    $Function = $_GET['Function'];

$menu = '';
if (isset($_POST['menu']))
    $menu = $_POST['menu'];
if (isset($_GET['menu']))
    $menu = $_GET['menu'];

$Function != '' ?? $Function = $menu;

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
    <div class="loader"></div>
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

                                var getParam = rmxGetParams();
                                var toMenu = getParam.menu;
                                var toCmd = getParam.CmdCommand;
                                var toStatus = getParam.status != null ? getParam.status : 'init';
                                var urlSelectMenu = rmxSelectMenu(sUrl, toMenu, userIdProfile, toCmd, toStatus);
                                var menuUrl = urlSelectMenu.menuUrl;
                                var paramS = urlSelectMenu.paramS;

                                var devMode = false;
                                if (devMode == true) {
                                    var toStatus = 'devMode';
                                    var userId = userIdProfile;
                                    var sCmd = "call sp_main_check_register ('" + userId + "','" + sCompCode + "')";
                                    var para = "?LinkCode=CHECK&LineId=" + userId + "&CmdCommand=" + sCmd;
                                }

                                if (toMenu == "register") {
                                    menuUrl = "menu/registerMenu.php" + paramS;
                                } else if (toMenu == "ticket") {
                                    menuUrl = "menu/ticketMenu.php" + paramS;
                                    url = sUrl + "frmView.php" + para;
                                } else if (toMenu == "profile") {
                                    menuUrl = "menu/profileMenu.php" + paramS;
                                } else if (toMenu == "search") {
                                    menuUrl = "menu/searchMenu.php" + paramS;
                                }

                                // alert('devMode Status: ' + devMode + ' ' + toStatus);
                                if (toStatus == 'devMode') {
                                    if (devMode == true) {
                                        menuUrl = url;
                                    } else {
                                        menuUrl = "menu/blankMenu.php";
                                    }
                                    alert('menuUrl: ' + menuUrl);
                                    window.location.assign(menuUrl);
                                    return;
                                } else if (toStatus == 'init' || toStatus == 'check') {
                                    //  alert('menuUrl: ' + menuUrl);
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