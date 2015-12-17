<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$terminal = new CTerminal();
$result = $terminal->getList( array("UF_COMP_ID" => "ASC", "ID" => "ASC"), array("UF_COMP_ID" => 1) );
// $result = $terminal->getList( array("UF_COMP_ID" => "ASC", "ID" => "ASC"), array("UF_CITY_ID" => false) );
CAkop::pr_var($result, 'result');

?>