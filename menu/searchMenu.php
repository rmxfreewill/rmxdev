<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . "/define_Global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/zApiFunction.php");
include("function/globalMenuFunc.php");

$sFlag = '';

$TableTitle = 'View Ticket';
if (isset($_POST['TableTitle']))
    $TableTitle = $_POST['TableTitle'];
if (isset($_GET['TableTitle']))
    $TableTitle = $_GET['TableTitle'];

// $RetCommand = '';
// $Ret = '';
// $UserName = '';
// $EMail = '';
// $Tel = '';
// $SoldToCode = '';
// $SoldToName = '';
// $sFlagMsg = '';
// $sFlag = '5';
// $sShowMsg = '';

function ticketSearchScreen()
{
    // $aa = '
    //     <label><b>LINE ID: </b>' . $LineId . '</label><p>
    // <label><b>SoldToCode: </b>' . $arrRet[5] . '</label><p>
    // <label><b>SoldToName: </b>' . $arrRet[6] . '</label><p>
    // <label><b>Tel: </b>' . $arrRet[4] . '</label><p>
    // <label><b>EMail: </b>' . $arrRet[3] . '</label><p>
    // ';

    $res = '
    <div class="login_container">
        <div class="login_container">
            <label for="txtFirst"><b>Start Date</b></label>
            <input type="date" dateformat="d M y" id="txtFirst">
            <label for="txtLast"><b>End Date</b></label>
            <input type="date" id="txtLast" dateformat="d M y">
            <label for="txtTicketNo"><b>Ticket No</b></label>
            <input type="text" id="txtTicketNo" value="">
            <input type="hidden" id="txtRet" value="<?php echo $RetCommand; ?>">
            <button type="button" id="btnSearch" onclick="checkSearch()">SEARCH</button>
        </div>

    </div>
    ';

    $res = '
    <div class="col-12 searchbox-color border border-dark rounded rounded-lg p-3 mt-3">
        <div class="col-12 mb-3 text-center">
            <h3>Ticket Search</h3>
        </div>
        <div class="col-12 mb-3">
            <div class="mb-3">
                <label for="txtFirst" class="form-label form-label-lg"><b>Start Date</b></label>
                <input type="date" class="form-control form-control-lg" dateformat="d M y" id="txtFirst">
            </div>
            <div class="mb-3">
                <label for="txtLast" class="form-label form-label-lg"><b>End Date</b></label>
                <input type="date" class="form-control form-control-lg" id="txtLast" dateformat="d M y">
            </div>
            <div class="mb-4" hidden>
                <label for="txtTicketNo" class="form-label form-label-lg"><b>Ticket No</b></label>
                <input type="text" class="form-control form-control-lg p-3" id="txtTicketNo" value="">
            </div>
            <div class="mb-3 mt-2">
                <button class="btn btn-success btn-lg rmxRegisterButton pt-3 pb-3" type="button" id="btnSearch" onclick="checkSearch()">
                    SEARCH
                </button>
            </div>
        </div>
    </div>
    ';

    echo $res;
}

function ticketSearchForm()
{
    $res = '
    <div class="m-3 bg-white shadow bg-white rounded" id="searchForm">
        <div class="p-4">
            <div class="col-12 text-center">
                <h2>SEARCH</h2>
            </div>
            <div class="col-12 mb-3">
                <div class="mb-3">
                    <label for="txtFirst" class="form-label form-label-lg"><b>Start Date</b></label>
                    <input type="date" class="form-control form-control-lg" dateformat="d M y" id="txtFirst">
                </div>
                <div class="mb-3">
                    <label for="txtLast" class="form-label form-label-lg"><b>End Date</b></label>
                    <input type="date" class="form-control form-control-lg" id="txtLast" dateformat="d M y">
                </div>
                <div class="mb-4" hidden>
                    <label for="txtTicketNo" class="form-label form-label-lg"><b>Ticket No</b></label>
                    <input type="text" class="form-control form-control-lg p-3" id="txtTicketNo" value="">
                </div>
                <div class="mb-3 mt-2">
                    <button class="btn btn-success btn-lg rmxRegisterButton pt-3 pb-3" type="button" id="btnSearch" onclick="checkSearch()">
                        SEARCH
                    </button>
                </div>
            </div>
        </div>
    </div>
    ';

    echo $res;
}

$getDataFromUrl = getDataFromUrl();
$CmdCommand = $getDataFromUrl->CmdCommand;
$LineId = $getDataFromUrl->LineId;
$status = $getDataFromUrl->status;

echo json_encode($getDataFromUrl);

if ($status == 'check') {
    // $RetCommand = sendQuery('QueryCommand', COMPANY_URL, $LineId, COMPANY_CODE, $CmdCommand);
    // $getData = getDataFromDatabase($getDataFromUrl);
    // $sFlag = $getData->sFlag;
} else if ($status == 'init') {
    $getData = getDataFromDatabase($getDataFromUrl);
    $sFlag = $getData->sFlag;
    $LineId = $getData->LineId;
    $RetCommand = $getData->RetCommand;
}

if ($sFlag != '0') {
    ticketSearchForm();
} else {
    // echo json_encode($RetCommand);
    // echo $status;
}
?>
<div id="searchLists"></div>
<script>
    function checkSearch() {
        var toMenu = 'search';
        var toStatus = 'check';
        var sUrl = "<? echo sURL; ?>";
        var sLineId = "<? echo  $getDataFromUrl->LineId; ?>";

        var txtTicketNo = $("#txtTicketNo").val();
        var sFirst = document.getElementById('txtFirst').value;
        var sLast = document.getElementById('txtLast').value;

        if (sFirst == "") {
            alert("Please select first date before click search");
            return;
        }

        if (sLast == "") {
            alert("Please select end date before click search");
            return;
        }

        if (sFirst != "" && sLast != "") {
            var dF = new Date(sFirst);
            sFirst = dF.getDate() + '/' + (dF.getMonth() + 1) + '/' + dF.getFullYear();
            var dL = new Date(sLast);
            sLast = dL.getDate() + '/' + (dL.getMonth() + 1) + '/' + dL.getFullYear();
            var sTableTitle = "Date " + sFirst + " to " + sLast;
            var paramTableTitle = "&TableTitle=" + sTableTitle;

            var sCmd = "call sp_comp_select_ticket('" + sLineId + "','" + sFirst + "','" + sLast + "')";
            var urlSelectMenu = rmxSelectMenu(sUrl, toMenu, sLineId, sCmd, toStatus);
            var param = urlSelectMenu.paramS;
            var menuUrl = "menu/searchMenu.php" + param + paramTableTitle;
            // alert(menuUrl);
            $("#rmxLiFFLayout").load(menuUrl);
        }

    }

    function getSearchLists() {

    }

    $(function() {
        var sFlag = "<?php echo $sFlag; ?>";
        if (sFlag != '') {
            $("#rmxLoader").hide();
        }
    });
</script>