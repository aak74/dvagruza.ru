<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$from = CAkop::getRequest("from", true);
$to = CAkop::getRequest("to", true);
$weight = CAkop::getRequest("weight", true);
$volume = CAkop::getRequest("volume", true);
$query = new CQuery();
$queryId = $query->add(array(
	"UF_FROM" => $from,
	"UF_TO" => $to,
	"UF_WEIGHT" => $weight,
	"UF_VOLUME" => $volume,
	"UF_TIME" => date("d.m.Y H:i:s")
));


$cities = new CCity();
/* Получаем перечень компаний в городе отправления и городе получения */
$companiesFrom = $cities->getCompaniesInCity($from);
$companiesTo = $cities->getCompaniesInCity($to);

// CAkop::pr_var($companiesFrom, 'companiesFrom');
// CAkop::pr_var($companiesTo, 'companiesTo');

echo json_encode( 
	array( 
		"comps" => array_keys( array_intersect($companiesFrom, $companiesTo) ),
		"query_id" => $queryId
	), 
	JSON_HEX_AMP 
);
?>