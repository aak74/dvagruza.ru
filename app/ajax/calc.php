<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

function str2float ($str) {
	return str_replace( " ", "", str_replace( ",", ".", $str ) );
}


$companyId = CAkop::getRequest("companyId", true);
$from = CAkop::getRequest("from", true);
$to = CAkop::getRequest("to", true);
// CAkop::pr_var($_REQUEST);

switch ($companyId) {
	case 1:
		$calc = new CPecom();
		break;
	case 2:
		$calc = new CTkkit();
		break;
	case 3:
		$calc = new CDellin();
		break;
	default:
		$calc = false;
		break;
}
if ($calc) {
	$res = $calc->calc( array(
		"from" => $from, 
		"to" => $to, 
		"weight" => str2float($weight), 
		"volume" => str2float($volume), 
	) );
	if ( $res ) {
		// Добавим к выдаче переданные в запросе параметры
		$res["companyId"] = $companyId;
		$res["from"] = $from;
		$res["to"] = $to;
		if ( $res["time"] == null) {
			$res["time"] = "...";
		}
		$result = array(
			"status" => "ok",
			"result" => $res,
			"msg" => ""
		);
	} else {
		$result = array(
			"status" => "error",
			"result" => false,
			"msg" => "Ошибка при расчете"
		);
		// TODO: записать данные об ошибке в БД

	}
} else {
	$result = array(
		"status" => "error",
		"result" => false,
		"msg" => "Wrong company id=($company)"
	);
}

$answer = new CAnswer();
$answer->add(array(
	"UF_QUERY" => CAkop::getRequest("queryId", true),
	"UF_COMP_ID" => $companyId,
	"UF_TIME" => date("d.m.Y H:i:s"),
	"UF_SUM" => $result["result"]["price"],
	"UF_TERM" => $result["result"]["time"],
	"UF_STATUS" => $result["status"],
	"UF_RESPONSE" => serialize( $result["result"]["response"] ),
));

unset($result["result"]["response"]);

echo json_encode($result, JSON_HEX_AMP );

?>