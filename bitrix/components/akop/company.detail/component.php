<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$company = new CCompany();
$arResult["DETAIL"] = $company->getItem( 
	array("UF_XML_ID" => $arParams["XML_ID"])
);

$terminal = new CTerminal();
$arResult["ITEMS"] = $terminal->getList( 
	array("UF_NAME" => "ASC"), 
	array("UF_COMP_ID" => $arResult["DETAIL"]["ID"])
);

unset($company);
unset($terminal);
$this->IncludeComponentTemplate();
?>