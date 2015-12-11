<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$terminals = new CTerminal();
// CAkop::pr_var($result, 'result');

$arResult["ITEMS_NEW"] = $terminals->getList( 
// $arResult["ITEMS"] = $terminals->getList( 
	array("UF_NAME" => "ASC", "ID" => "ASC"), 
	array("UF_CITY_ID" => false) 
);
$cities = new CCity();
$arResult["ITEMS"] = $cities->getList( array("UF_NAME_SHORT" => "ASC"), array() );
/*
$cities = new CCityAll();
$arResult["ITEMS"] = $cities->getList( array("UF_NAME_SHORT" => "ASC") );
// CAkop::pr_var($arResult, '$arResult');

unset($cities);
unset($terminals);
*/
$this->IncludeComponentTemplate();
?>