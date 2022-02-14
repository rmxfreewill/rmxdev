<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$sFlag = '';

try {
    include_once("zMenuFunction.php");

    $getDataFromUrl = getDataFromUrlv2();
    $status = $getDataFromUrl->status;

    if ($status == 'init') {
        $notFound =  "<center><h2><br>Not Found User</h2></center><p>";
        $getDataFromDatabase = getDataFromDatabase($getDataFromUrl);
        $sFlag = $getDataFromDatabase->sFlag;
    }

    if ($sFlag != '0') {
        $getTicketFromDatabase = getTicketFromDatabase($getDataFromUrl, $getDataFromDatabase);
        // showTicketList($getTicketFromDatabase);
    } else {
        echo $notFound;
        echo  $getDataFromDatabase->status;
    }
    echo $sFlag;
} catch (\Throwable $th) {
    $sFlag = '0';
    echo $th;
}

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
        var sFlag = "<?php echo $sFlag; ?>";
        if (sFlag != '') {
            $("#rmxLoader").hide();
        }
    });
</script>