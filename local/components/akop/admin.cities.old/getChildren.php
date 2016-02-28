<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$cities = new CCity();
echo json_encode($cities->getListChildren(CAkop::getRequest($_POST["id"], true)), JSON_HEX_AMP);
?>