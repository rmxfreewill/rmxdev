<?php

error_reporting(-1);
ini_set('display_errors', 'On');


$GLOBALS['COMPANY_URL'] =  COMPANY_URL;
$GLOBALS['REGISTER_URL'] =   REGISTER_URL;
$GLOBALS['COMPANY_CODE'] =   COMPANY_CODE;
$GLOBALS['LIFF_ID'] =   LIFF_ID;
$GLOBALS['sURL'] =   sURL;


$getDataFromUrl = getDataFromUrl($GLOBALS['COMPANY_CODE'], $GLOBALS['COMPANY_URL'], $GLOBALS['REGISTER_URL']);
$status = $getDataFromUrl->status;

// if ($status == 'init') {
//     $notFound =  "<center><h2><br>Not Found User</h2></center>";
//     $getDataFromDatabase = getDataFromDatabase($GLOBALS['COMPANY_URL'], $getDataFromUrl);
//     $sFlag = $getDataFromDatabase->sFlag;
// }

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>RMX LINE OFFICIAL</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="en-th">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <h1>Ticket</h1>
    <?php
    // if ($sFlag != '0') {
        // $getTicketFromDatabase = getTicketFromDatabase($getDataFromUrl, $getDataFromDatabase);
        // showTicketList($getTicketFromDatabase);
    // } else {
        // echo $notFound;
        // echo "<p>";
        // echo  $getDataFromDatabase->status;
    // }
    ?>
    <script>


        // function openPage(pageName, elmnt, color) {
        //     var i, tabcontent, tablinks;
        //     tabcontent = document.getElementsByClassName("tabcontent");
        //     for (i = 0; i < tabcontent.length; i++) {
        //         tabcontent[i].style.display = "none";
        //     }
        //     tablinks = document.getElementsByClassName("tablink");
        //     for (i = 0; i < tablinks.length; i++) {
        //         tablinks[i].style.backgroundColor = "";
        //     }
        //     document.getElementById(pageName).style.display = "block";
        //     elmnt.style.backgroundColor = color;
        // }

        // function fillTicketData(tableName, asCol, asData) {
        //     var table = document.getElementById(tableName);
        //     if (table) {
        //         var sHtml = "";
        //         var nRLen = asData.length;
        //         for (var r = 0; r < nRLen; r++) {
        //             var sC = asCol[r];
        //             var sD = asData[r];
        //             sHtml = sHtml + "<tr><th>" + sC + "</th><td class='textLeft'>" + sD + "</td></tr>";
        //         }
        //         table.innerHTML = sHtml;
        //     }
        // }

        $(function() {
            $(".loader").hide();
        });
    </script>
</body>

</html>