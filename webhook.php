<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include_once("define_Global.php");
include_once("rmxWebhookFunction.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function rmxGetDataLiff($menu, $LineId)
{
  $rmx_api_url = RMX_SERVER_API_URL;
  $param_menu = "?menu=$menu&lineid=$LineId";
  $url = $rmx_api_url  . $param_menu;
  $headers = ["Authorization: Bearer " . BEARER_TOKEN];

  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, array());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    return  $data;
  } catch (Exception $ex) {
    print('Error rmxProfileLiff: ' . $ex);
  }
}

function ticketDetailRowLayout($title, $val)
{
  if ($val == '' || $val == null) {
    $valtmp = '-';
  } else {
    $valtmp  = $val;
  }

  $objDetailRow = new stdClass;
  $objDetailBaselineTitle = new stdClass;
  $objDetailBaselineValue = new stdClass;

  //Title
  $objDetailBaselineTitle->type = "text";
  $objDetailBaselineTitle->text = $title;
  $objDetailBaselineTitle->size = "xs";
  $objDetailBaselineTitle->color = "#AAAAAA";
  $objDetailBaselineTitle->weight = "bold";
  $objDetailBaselineTitle->flex = 3;
  $objDetailBaselineValue->wrap = true;
  $objDetailBaselineTitle->contents = [];

  //Value
  $objDetailBaselineValue->type = "text";
  $objDetailBaselineValue->text = $valtmp;
  $objDetailBaselineValue->size = "xs";
  $objDetailBaselineValue->color = "#666666";
  $objDetailBaselineValue->flex = 4;
  $objDetailBaselineValue->align = "end";
  $objDetailBaselineValue->wrap = true;
  $objDetailBaselineValue->contents = [];

  $contentsList = [$objDetailBaselineTitle, $objDetailBaselineValue];

  $objDetailRow->type = "box";
  $objDetailRow->layout = "baseline";
  $objDetailRow->spacing = "xs";
  $objDetailRow->contents = $contentsList;

  return $objDetailRow;
}

function selectTicketDetail($arrVal)
{
  $data = [];
  $title = array(
    "Ticket Number", "Product code", "Date", "Time", "Company Name",
    "Customer Name", "Contact Person", "Mobile", "Ship To Location", "Date to Load ",
    "Time to Load ", "Date to Leave", "Time to Leave", "Date to Jobsite", "Time to Jobsite",
    "Truck code", "Drive Name", "Load size (m3)", "Plant Code", "Product Name",
    "Slump", "Strength CU/CY", "Special Instruction"
  );

  // $arrVal = array(
  //     "1011808270007", "24/10/2018", "S01P901-00000331", "27/08/2018", "320000106 SH_Name 105",
  //     "997525133500 WPROOF PMP 25MPa 25mm S120 25@7DWPC1", "cV101 RMX Plant 101", "78", "2", "Theary Theary_",
  //     "FS22", "51E00491", "16:54:43", "Delivery", "5",
  //     "a", "a", "a", "a", "a",
  //     "b", "b", "----"
  // );

  for ($i = 0; $i < count($title); $i++) {
    array_push(
      $data,
      ticketDetailRowLayout($title[$i], $arrVal[$i])
    );
  }

  return $data;
}

function ticketDetailFlexMessage($LineId)
{
  $objSeparator = new stdClass;
  $objSeparator->type = "separator";

  $objTitleH1 = new stdClass;
  $objTitleH1->type = "text";
  $objTitleH1->text = "Ticket Detail";
  $objTitleH1->weight = "bold";
  $objTitleH1->color = "#B6961EFF";
  $objTitleH1->size = "xl";
  $objTitleH1->wrap = true;
  $objTitleH1->contents = [];

  $objDetail = new stdClass;
  $objDetail->type = "box";
  $objDetail->layout = "vertical";
  $objDetail->spacing = "md";
  $objDetail->margin = "lg";

  $arrVal = json_decode(rmxGetDataLiff('ticketdetails', $LineId), true)[0];
  $objDetail->contents = selectTicketDetail($arrVal);
  $output = array($objTitleH1, $objSeparator, $objDetail);

  $replyText["type"] = "flex";
  $replyText["altText"] =  "Ticket Detail";
  $replyText["contents"]["type"] = "bubble";
  $replyText["contents"]["body"]["type"] = "box";
  $replyText["contents"]["body"]["layout"] = "vertical";
  $replyText["contents"]["body"]["spacing"] = "sm";
  $replyText["contents"]["body"]["contents"] = $output;

  return $replyText;
}

function replyJsonMessage($jsonData, $LineId)
{
  $flexMessage = '';
  $textTypeParams = $jsonData["events"][0]["message"]["type"];
  if ($textTypeParams == 'text') {
    $textParams = $jsonData["events"][0]["message"]["text"];
    $case = trim(strtolower($textParams));
    if ($case  == 'status') {
      $flexMessage = ticketDetailFlexMessage($LineId);
    } else if ($case  == 'logout') {
      rmxChangeRegisterRichMenu($LineId);
    } else if ($case == 'hi') {
      $flexMessage = '{
                "type": "flex",
                "altText": "Ticket Detail",
                "contents": {
                  "type": "bubble",
                  "header": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                      {
                        "type": "text",
                        "text": "Ticket Detail",
                        "size": "xl",
                        "weight": "bold",
                        "color": "#B6961EFF",
                        "wrap": true
                      },
                      {
                        "type": "separator"
                      }
                    ]
                  },
                  "body": {
                    "type": "box",
                    "layout": "vertical",
                    "spacing": "sm",
                    "contents": [
                      {
                        "type": "box",
                        "layout": "horizontal",
                        "spacing": "sm",
                        "contents": [
                          {
                            "type": "text",
                            "text": "LineID",
                            "size": "sm",
                            "color": "#AAAAAA",
                            "weight": "bold",
                            "flex": 2,
                            "wrap": true
                          },
                          {
                            "type": "text",
                            "text": "' . $LineId . '",
                            "size": "sm",
                            "color": "#666666",
                            "flex": 4,
                            "wrap": true,
                            "align": "end"
                          }
                        ]
                      }
                    ]
                  }
                }
              }
            ';
      $flexMessage = json_decode($flexMessage);
    }
  }

  return $flexMessage;
}

function replyJsonMessagev2($jsonData, $LineId)
{
  $flexMessage = '';
  $textTypeParams = $jsonData["events"][0]["message"]["type"];
  if ($textTypeParams == 'text') {
    $textParams = $jsonData["events"][0]["message"]["text"];
    $case = trim(strtolower($textParams));
    if ($case  == 'hi') {
      $flexMessage = '
      {
        "type": "text",
        "text": "Hello, I am Cony!!",
        "sender": {
            "name": "Cony",
            "iconUrl": "https://line.me/conyprof"
        }
    }
      ';
    } else if ($case  == 'logout') {
      rmxChangeRegisterRichMenu($LineId);
    }
  }
  return $flexMessage = json_decode($flexMessage);
}


function sendMessageWebhook($LINEData)
{

  // $jsonData = json_decode($LINEData, true);
  // $replyToken = $jsonData["events"][0]["replyToken"];
  // $replyUserId = $jsonData["events"][0]["source"]["userId"];
  // $MessageType = $jsonData["events"][0]["message"]["type"];
  // $MessageText = $jsonData["events"][0]["message"]["text"];
  // $replyJson["replyToken"] = $replyToken;
  // $replyJson["to"] = getLineIdAll($replyUserId, 'lineid');

  // $arrVal = json_decode(rmxGetDataLiff('ticketdetails', $replyUserId), true);
  // $replyCount = count($arrVal);
  // for ($i = 0; $i < $replyCount; $i++) {
  //     $replyJson["messages"][0] = replyJsonMessage($jsonData, $replyUserId);
  //     $encodeJson = json_encode($replyJson);
  //     $results = sendMessage($encodeJson);
  //     echo $results;
  //     http_response_code(200);
  // }
}


function getLineIdAll($LineId, $getType)
{
  $ProfileAndSoldtocode = rmxGetDataLiff('ProfileAndSoldtocode', $LineId);
  $ProfileAndSoldtocodeObj = json_decode($ProfileAndSoldtocode);
  $res = $ProfileAndSoldtocodeObj->soldtocode;
  if ($getType == 'lineid') {
    $res = $ProfileAndSoldtocodeObj->lineid;
  }
  return $res;
  // return ['U194d6a8a8d6557a6b1ee0e2f16737d77'];
}

function inputWebhook($LINEData)
{
  $jsonData = json_decode($LINEData, true);
  $replyToken = $jsonData["events"][0]["replyToken"];
  $replyUserId = $jsonData["events"][0]["source"]["userId"];
  if ($replyUserId != null && $replyUserId != '') {
    $MessageType = $jsonData["events"][0]["message"]["type"];
    $MessageText = $jsonData["events"][0]["message"]["text"];
    $replyJson["replyToken"] = $replyToken;
    // $replyJson["to"] = getLineIdAll($replyUserId, 'lineid');
    $replyJson["to"] = [$replyUserId];
    $replyJson["messages"][0] = replyJsonMessagev2($jsonData, $replyUserId);
    // $replyJson["messages"][0] = replyJsonMessage($jsonData, $replyUserId);
    $encodeJson = json_encode($replyJson);
    echo $encodeJson;
    $results = sendMessage($encodeJson);
    echo $results;
    http_response_code(200);
  }
}

//
//
//
$LINEData = file_get_contents('php://input');
inputWebhook($LINEData);
//
//
//





function replyJsonPostBack($jsonData)
{
  // $postbackParams = $jsonData["events"][0]["postback"]["data"];
  // parse_str($postbackParams, $arr);
  // $ActionMenuText = $arr["action"];
  // if ($ActionMenuText == 'status') {
  //     $replyJson["messages"][0] = ticketDetailFlexMessage();
  // } else if ($ActionMenuText == 'text') {
  //     $replyJson["messages"][0] = testFlexMessage('TEXTTEST');
  // }
}
