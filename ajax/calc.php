<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$company = CAkop::getRequest("company", true);
$from = CAkop::getRequest("from", true);
$to = CAkop::getRequest("to", true);
CAkop::pr_var($_REQUEST);

switch ($company) {
	case 1:
		$calc = new CPecom();
		break;
	case 2:
		$calc = new CKit();
		break;
	case 3:
		$calc = new CDellin();
		break;
	default:
		$calc = false;
		break;
}
if ($calc) {
	$result = array(
		"status" => "ok",
		"result" => $calc->calc(
			array(
				"from" => $from, 
				"to" => $to, 
				"weight" => $weight, 
				"volume" => $volume, 
			)
		),
		"msg" => ""
	);
} else {
	$result = array(
		"status" => "error",
		"result" => false,
		"msg" => "Wrong company id=($company)"
	);
}
echo json_encode($result, JSON_HEX_AMP );

?>