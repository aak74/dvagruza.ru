<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$company = new CTkkit();
$company->updateTerminals();
// $result = $company->_getTerminals();
// CAkop::pr_var($result, 'result');

$terminal = new CTerminal();
$result = $terminal->getList( array("UF_NAME" => "ASC"), array("UF_COMP_ID" => 2) );
CAkop::pr_var($result, 'result');

?>