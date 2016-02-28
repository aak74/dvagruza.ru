<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$cities = new CCity();
$arResult["ITEMS"] = $cities->getListActive();
unset($cities);
$this->IncludeComponentTemplate();
?>