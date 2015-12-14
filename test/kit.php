<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

echo 1;
$tk = new CTkkit();

$arResult = $tk->calc(array(
	"from" => 632,
    "to" => 1,
    "company" => 3,
    "weight" => 200,
    "volume" => 1,
));
/*
$terminal = new CTerminal();
// CAkop::pr_var($result, 'result');

$arResult = $terminal->getList( 
// $arResult["ITEMS"] = $terminals->getList( 
	array("UF_NAME" => "ASC", "ID" => "ASC"), 
	array("UF_CITY_ID" => 1, "UF_COMP_ID" => 2) 
);
*/
CAkop::pr_var($arResult, 'arResult');

echo 2;
?>