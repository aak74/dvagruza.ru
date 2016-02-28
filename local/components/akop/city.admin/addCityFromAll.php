<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CAkop::pr_var($_REQUEST, '$_REQUEST');

$cityAll = new CCityAll();
$item = $cityAll->getItem(	array("ID" => CAkop::getRequest("id", true) ) );
CAkop::pr_var($item, '$item');
$city = new CCity();
$terminal = new CTerminal();
$filter["UF_KLADR"] = $item["UF_KLADR"];

$params = array(
	"UF_KLADR" => $item["UF_KLADR"],
	"UF_NAME_SHORT" => $item["UF_NAME_SHORT"],
	"UF_NAME_FULL" => $item["UF_NAME_FULL"],
	"UF_NAME_REGION" => $item["UF_NAME_REGION"],
	"UF_ACTIVE" => 1,
);

$cityIdNew = $city->updateEx($filter, $params);

$params = array(
	"UF_KLADR" => $item["UF_KLADR"],
	"UF_NAME_SHORT" => $item["UF_NAME_SHORT"],
	"UF_NAME_FULL" => $item["UF_NAME_FULL"],
	"UF_NAME_REGION" => $item["UF_NAME_REGION"],
	"UF_ACTIVE" => 1,
);

$terminal->update( 
	CAkop::getRequest("terminal_id", true),
	array(
		"UF_CITY_ID" => $cityIdNew
	)
);


// CAkop::pr_var($result);
// echo json_encode($result, JSON_FORCE_OBJECT);
// foreach ($list as $key => $value) {
// 	$result[] = $value;
// }
echo '{"cityIdNew": "' . $cityIdNew . '"}';
?>