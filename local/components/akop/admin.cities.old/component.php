<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$cities = new CCity();

$arResult["ITEMS"] = $cities->getListMain();
// CAkop::pr_var($arResult, '$arResult');

unset($cities);

$this->IncludeComponentTemplate();
?>