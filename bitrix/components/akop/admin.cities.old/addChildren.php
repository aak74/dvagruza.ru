<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$cities = new CCity();

$parentId = CAkop::getRequest("parent_id", true);
$ids = CAkop::getRequest("ids");
CAkop::pr_var($_REQUEST, '$_REQUEST');
CAkop::pr_var($ids, '$ids');

$cities->setParent( $ids, $parentId );

echo json_encode($cities->getListChildren($parentId), JSON_HEX_AMP);
?>