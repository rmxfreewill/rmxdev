<?php
/*    include_once("index.html"); */

session_start();

error_reporting(E_ALL & ~E_NOTICE);
include_once("rmxLineFunction.php");

$CompanyUrl = COMPANY_URL;
$RegisterUrl = REGISTER_URL;
$CompanyCode = COMPANY_CODE;
$LiffId = LIFF_ID;
$sURL = sURL;


$LinkCode = '';
if (isset($_POST['LinkCode']))
    $LinkCode = $_POST['LinkCode'];
if (isset($_GET['LinkCode']))
    $LinkCode = $_GET['LinkCode'];

$LineId = '';
if (isset($_POST['LineId']))
    $LineId = $_POST['LineId'];
if (isset($_GET['LineId']))
    $LineId = $_GET['LineId'];

$CmdCommand = '';
if (isset($_POST['CmdCommand']))
    $CmdCommand = $_POST['CmdCommand'];
if (isset($_GET['CmdCommand']))
    $CmdCommand = $_GET['CmdCommand'];

$TableTitle = 'View Ticket';
if (isset($_POST['TableTitle']))
    $TableTitle = $_POST['TableTitle'];
if (isset($_GET['TableTitle']))
    $TableTitle = $_GET['TableTitle'];

$RetCommand = '';
$Ret = '';

$UserName = '';
$EMail = '';
$Tel = '';
$SoldToCode = '';
$SoldToName = '';
$sFlagMsg = '';
$sFlag = '5';
$sTitle = 'View';
$sShowMsg = '';

if ($LinkCode == 'VIEW') {

    $RetCommand = send_query($CompanyUrl, $LineId, $CompanyCode, $CmdCommand);
    if ($RetCommand) {
    }
    $sFlag = '5';
} else if ($LinkCode == 'CHECK') {

    $RetCommand = send_command($CompanyUrl, '', '', $CmdCommand);
    if ($RetCommand) {
        //select $sFlagMsg,$nFlag,$sTUserName,$sTEMail,$sTMobileNo;
        $ASRet = [];
        $ASRet = explode("^c", $RetCommand);
        if (count($ASRet) >= 2) {
            $sFlagMsg = $ASRet[0];
            $sFlag = $ASRet[1];
            $sShowMsg = '0';
            if ($sFlag != '0') {
                $sTitle = 'View';

                $CmdCommand = "call sp_comp_select_ticket('" . $LineId . "','30/9/2018','30/9/2021')";

                $RetCommand = send_query($CompanyUrl, $LineId, $CompanyCode, $CmdCommand);
            }
        }
    }
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="en-th">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">


    <title>History</title>
    <!-- <title><?php echo $sTitle; ?></title> -->

    <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>

    <link rel="stylesheet" href="style.css">

    <style>
        * {
            box-sizing: border-box
        }

        /* Set height of body and the document to 100% */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial;
        }

        div.scrollmenu {
            background-color: #333;
            overflow: auto;
            white-space: nowrap;
            height: 40px;

        }

        div.scrollmenu a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }

        div.scrollmenu a:hover {
            background-color: #777;
        }

        /* Style tab links */
        .tablink {
            margin: 0;
        }

        .tablink:hover {
            background-color: #777;
        }

        /* Style the tab content (and add height:100% for full page content) */
        .tabcontent {
            color: white;
            display: none;
            padding: 10px 20px;
            height: 100%;
        }


        table.tblticket {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        table.tblticket td,
        table.tblticket th {

            border: 1px solid black;
            padding: 8px;
        }


        table.tblticket th {
            /*padding-top: 12px;*
        /*padding-bottom: 12px;*/
            text-align: right;
            /*background-color: #04AA6D;*/
            color: blue;
        }

        table.tblticket td {
            /*padding-top: 12px;*
        /*padding-bottom: 12px;*/
            text-align: left;
            /*background-color: #04AA6D;*/
            color: black;
        }
    </style>
</head>

<body>
    <form class="animate" method="GET" enctype="multipart/form-data">

        <?php

        if ($sFlag == '0' || $sFlag == '') {
            echo "<center><h1>No Record List</h1></center>";
        } else {
            if ($RetCommand) {
                $asTable = explode("^t", $RetCommand);
                if (count($asTable) > 0) {
                    $arTmp = explode("^f", $asTable[0]);
                    if (count($arTmp) > 1) {
                        $asCol = explode("^c", $arTmp[0]);
                        $asRow = explode("^r", $arTmp[1]);

                        if (count($asRow) > 0) {
                            $nLoop = 0;

                            $nRLen = count($asRow);
                            $nCLen = count($asCol);
                            $sTab = "";
                            $sPage = "";
                            if ($nRLen > 10) $nRLen = 10;

                            for ($n = 0; $n < $nRLen; $n++) {
                                $sRow = $asRow[$n];

                                $asData = explode("^c", $sRow);
                                $nDLen = count($asData);
                                if ($nDLen > 0) {
                                    $sTicketNo = $asData[0];
                                    $sTab = $sTab . "<a class='tablink' href='#' "
                                        . "onclick=\"openPage('div" . $sTicketNo . "_" .
                                        "', this, 'red')\">" . $sTicketNo . "</a>";

                                    $sPage = $sPage . "<div id='div" . $sTicketNo . "_" .
                                        "' class='tabcontent'>";
                                    $sPage = $sPage . "<table class='tblticket'>";
                                    for ($r = 0; $r < $nDLen; $r++) {
                                        $sC = $asCol[$r];
                                        $sD = $asData[$r];

                                        $sPage = $sPage . "<tr><th>" . $sC
                                            . "</th><td class='textLeft'>" . $sD . "</td></tr>";
                                    }
                                    $sPage = $sPage . "</table></div>";
                                }
                            }

                            $sTab = "<div class='scrollmenu'>" . $sTab . "</div>";
                            echo $sTab;
                            echo $sPage;
                        }
                    }
                }
            }
        }

        ?>

        <input type="hidden" id="txtFlag" value="<?php echo $sFlag; ?>">
        <input type="hidden" id="txtCompanyCode" value="<?php echo $CompanyCode; ?>">
        <input type="hidden" id="txtLiffId" value="<?php echo $LiffId; ?>">
        <input type="hidden" id="txtMsg" value="<?php echo $sFlagMsg; ?>">
        <input type="hidden" id="txtShowMsg" value="<?php echo $sShowMsg; ?>">
        <input type="hidden" id="txtRetCommand" value="<?php echo $RetCommand; ?>">
        <input type="hidden" id="txtLineId" value="<?php echo $LiffId; ?>">
        <input type="hidden" id="txtTableTitle" value="<?php echo $TableTitle; ?>">
        <input type="hidden" id="txtsURL" value="<?php echo $sURL; ?>">

    </form>

    <script>
        function openPage(pageName, elmnt, color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;
        }

        window.onload = function() {
            var myLiffId = document.getElementById('txtLiffId').value;
            initializeLiff(myLiffId);
        };


        function initializeLiff(myLiffId) {
            liff.init({
                    liffId: myLiffId
                })
                .then(() => {
                    initializeApp();
                })
                .catch((err) => {});
        }


        function initializeApp() {

            if (liff.isLoggedIn()) {

                liff.getProfile().then(profile => {
                        const userId = profile.userId;
                        if (document.getElementById('txtLineId'))
                            document.getElementById('txtLineId').value = userId;

                        if (document.getElementById('txtShowMsg')) {
                            var sShow = document.getElementById('txtShowMsg').value;
                            if (sShow == "1") {
                                var sMsg = document.getElementById('txtMsg').value;
                                if (sMsg.length > 0) alert(sMsg);
                            }
                        }
                        // alert(userId);
                    })
                    .catch((err) => {
                        alert(err);
                        console.log('error', err);
                    });


            }


        }






        function fillTicketData(tableName, asCol, asData) {

            var table = document.getElementById(tableName);
            if (table) {
                var sHtml = "";
                var nRLen = asData.length;
                for (var r = 0; r < nRLen; r++) {
                    var sC = asCol[r];
                    var sD = asData[r];
                    sHtml = sHtml + "<tr><th>" + sC + "</th><td class='textLeft'>" + sD + "</td></tr>";
                }
                table.innerHTML = sHtml;


            }

        }
        // Get the modal
    </script>

</body>

</html>