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
$arResult["ITEMS"] = array_merge(
	array(
		0 => array(
				"ID" => 0,
				// "UF_NAME_SHORT" => "Unknown"
				"UF_NAME_SHORT" => "Не установлен"
			)
	),
	$cities->getListActive()
);

/*
$cities = new CCityAll();
$arResult["ITEMS"] = $cities->getList( array("UF_NAME_SHORT" => "ASC") );
// CAkop::pr_var($arResult, '$arResult');

unset($cities);
unset($terminals);
*/
$this->IncludeComponentTemplate();
?>