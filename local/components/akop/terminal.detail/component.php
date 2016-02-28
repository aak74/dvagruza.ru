<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$terminal = new CTerminal();
$arResult["DETAIL"] = $terminal->getItem( 
	array("ID" => $arParams["ID"])
);

$company = new CCompany();
$arResult["COMPANY"] = $company->getItem( 
	array("ID" => $arResult["DETAIL"]["UF_COMP_ID"])
);

$city = new CCity();
$arResult["CITY"] = $city->getItem( 
	array("ID" => $arResult["DETAIL"]["UF_CITY_ID"])
);


unset($city);
unset($company);
unset($terminal);
$this->IncludeComponentTemplate();
?>