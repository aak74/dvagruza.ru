<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$city = new CCity($arParams["ID"]);
$arResult["DETAIL"] = $city->getItem( 
	array("ID" => $arParams["ID"])
);
$terminals = $city->getTerminals($arParams["ID"]);
foreach ($terminals as $item) {
	if ( !isset($arResult["ITEMS"][ $item["COMPANY_NAME"] ]) ) {
		$arResult["ITEMS"][ $item["COMPANY_NAME"] ] = array(
			"COMPANY_NAME" => $item["COMPANY_NAME"],
			"COMPANY_XML_ID" => $item["COMPANY_XML_ID"],
		);
	}
	$arResult["ITEMS"][ $item["COMPANY_NAME"] ]["TERMINALS"][] = $item;
}


unset($terminals);
unset($city);
$this->IncludeComponentTemplate();
?>