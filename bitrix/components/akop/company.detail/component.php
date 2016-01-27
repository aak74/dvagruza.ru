<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$company = new CCompany($arParams["XML_ID"]);
$arResult["DETAIL"] = $company->getItem( 
	array("UF_XML_ID" => $arParams["XML_ID"])
);
$arResult["ITEMS"] = $company->getCities();

unset($company);
$this->IncludeComponentTemplate();
?>