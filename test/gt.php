<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// $pecom = new CPecom();
$branch = new CBranch();
$list = $branch->getList(array("ID" => "asc"), array("UF_COMP_ID" => 3));
CAkop::pr_var($list, 'list');

$tk = new CDellin();
// $result = $tk->getCities();
// $result = $tk->_getTerminals();
// CAkop::pr_var($result, 'result');
$result = $tk->updateTerminals();
// foreach ($result as $key => $terminal) {
//    echo $terminal["name"], "<br>";
// }

$list = $branch->getList(array("ID" => "asc"), array("UF_COMP_ID" => 3));
CAkop::pr_var($list, 'list');
?>