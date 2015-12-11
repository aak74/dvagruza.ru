<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$dl = new CDellin();
$result = $dl->getCities();
// $result = $dl->getPlaces();
// $result = $branches->getList(array(), array("UF_CITY_ID" => 121, "UF_COMP_ID" => 1));
CAkop::pr_var($result, 'result');
// $result = $cities->getList(array("UF_NAME" => "asc"));
// CAkop::pr_var($result, 'result');
?>