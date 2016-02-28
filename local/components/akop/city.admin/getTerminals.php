<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// CAkop::pr_var($_REQUEST["id"], '$_REQUEST["id"],');
$city = new CCity();
$result = $city->getListTerminals( CAkop::getRequest("id", true) );
echo json_encode($result, JSON_HEX_AMP);
?>