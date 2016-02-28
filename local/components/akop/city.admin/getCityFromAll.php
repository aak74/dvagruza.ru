<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// CAkop::pr_var($_REQUEST["id"], '$_REQUEST["id"],');
$name = CAkop::getRequest("name", true);
$city = new CCityAll();
$list = $city->getList(
	array("UF_NAME_SHORT" => "ASC"),
	array("UF_NAME_SHORT" => $name)
);
if ( empty($list) ) {
	$list = $city->getList(
		array("UF_NAME_SHORT" => "ASC"),
		array("?UF_NAME_SHORT" => substr($name, 0, 8) )
		// array("UF_NAME_FULL" => substr($name, 0, 6) )
		// array("UF_NAME_SHORT" => "%" . substr($name, 0, 6) )
	);
}
foreach ($list as $key => $value) {
	$result[] = $value;
}
echo json_encode($result, JSON_HEX_AMP);
?>