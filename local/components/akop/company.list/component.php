<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$company = new CCompany();
$arResult["ITEMS"] = $company->getList( 
	array("UF_NAME" => "ASC"), 
	false, 
	array("UF_NAME", "UF_XML_ID", "UF_SITE") 
);

unset($company);
$this->IncludeComponentTemplate();
?>