<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$cities = new CHLReference(1);
$branches = new CHLReference(3);
$result = $branches->getList(array(), array("UF_COMP_ID" => 1));
// $result = $branches->getList(array(), array("UF_CITY_ID" => 121, "UF_COMP_ID" => 1));
CAkop::pr_var($result, 'result');
$result = $cities->getList(array("UF_NAME" => "asc"));
CAkop::pr_var($result, 'result');
?>