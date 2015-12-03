<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$from = CAkop::getRequest("from", true);
$to = CAkop::getRequest("to", true);
$cities = new CCity();
/* Получаем перечень компаний в городе отправления и городе получения */
$companiesFrom = $cities->getCompaniesInCity($from);
$companiesTo = $cities->getCompaniesInCity($to);
echo json_encode( array_keys( array_intersect($companiesFrom, $companiesTo) ), JSON_HEX_AMP );
?>