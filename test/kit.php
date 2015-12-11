<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

echo 1;
$tk = new CKit();
$c = $tk->getCities();
CAkop::pr_var($c, 'c');

echo 2;
?>