<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$company = new CCompany();
$list = $company->getList(array("UF_NAME" => "ASC"), array(), array("UF_NAME"));
CAkop::pr_var($list, '$list');

?>