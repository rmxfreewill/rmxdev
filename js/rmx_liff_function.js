function rmxCloseWindow() {
    if (liff.getOS() != "web") {
        liff.closeWindow();
    }
}

function rmxGetParams() {
    var toStatus = null;
    var url = new URL(document.URL);
    toStatus = url.searchParams.get("status");
    var toMenu = url.searchParams.get("menu");
    var toCmd = url.searchParams.get("CmdCommand");
    const param = {menu:toMenu,status:toStatus,CmdCommand:toCmd};
    return param;
}

function rmxSelectMenu(sUrl = String ,toMenu = String, userId = String,sCmd = String,status = String) {

    //paramCmdCommand
    var paramCmdCommand = sCmd != '' ? "&CmdCommand=" + sCmd : '';

    //paramUserId
    var paramUserId = "&LineId=" + userId;

    //paramRoutes
    var RoutesStatus = "status="+status;
    var paramRoutes = RoutesStatus + '&menu=' + toMenu;

    var param = "?" + paramRoutes + paramUserId + paramCmdCommand;
    var url = sUrl + "index.php";
    var selectMenu = url + param;

    const rmxSelectMenu = {menuUrl:selectMenu,paramS:param};

    return rmxSelectMenu;
}



// async function initializeLiff() {
//     var myLiffId = document.getElementById('txtLiffId').value;
//     await liff.init({
//             liffId: myLiffId
//         })
//         .then(() => {
//             liff.isLoggedIn() ? getProfileLiffUserId() : liff.login();
//         })
//         .catch((err) => {
//             console.log("initializeLiff: " + err);
//         });
// }



// async function rmxInitializeLiff(myLiffId, type) {
//     await liff.init({
//         liffId: myLiffId
//     })
//         .then(() => {
//             type == 'logout' && liff.isLoggedIn() ? liff.closeWindow() : alert('Logout');
//             type == 'close' && liff.isLoggedIn() ? liff.closeWindow() : alert('Register Success');
//         })
//         .catch((err) => {
//             console.log("initializeLiff: " + err);
//         });
// }

    // switch (toMenu) {
    //     case "register":
    //         // url = URL + "frmRegister.php" + para;
    //         url = URL + folder + "registerScreen.php" + para; 
    //         break;
    //     case "ticket":
    //         url = URL + "frmTicket.php" + para;
    //         break;
    //     case "search":
    //         url = URL + "frmSearch.php" + para;
    //         break;
    //     case "profile":
    //         url = URL + "frmProfile.php" + para;
    //         break;
    //     default:
    //         url = URL + folder + "registerScreen.php" + para;
    //         break;
    // } 