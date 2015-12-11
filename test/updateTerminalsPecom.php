<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$company = new CPecom();
$list = $company->updateTerminals();

$terminal = new CTerminal();
$result = $terminal->getList(array("UF_NAME" => "ASC"));
CAkop::pr_var($result, 'result');
?>