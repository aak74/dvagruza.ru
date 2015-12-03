<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/iblock.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/prolog.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$APPLICATION->SetTitle("Управление городами");
// $APPLICATION->AddHeadString('<link rel="stylesheet" href="/bitrix/templates/dvagruza/bootstrap/css/bootstrap.min.css">', true);
$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">', true);
CJSCore::Init(array("jquery"));
// $APPLICATION->AddHeadString('<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>', true);
	
?>
<div class="cities">
<?
$APPLICATION->IncludeComponent(
	"akop:admin.cities",
	"",
	Array(),
	false

);
?>	
</div>