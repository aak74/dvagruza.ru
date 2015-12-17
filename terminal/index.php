<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Терминал");
$APPLICATION->SetPageProperty("keywords", "грузоперевозки, транспорт, сборные грузы");
?>
<?
// $APPLICATION->SetTitle($arResult["DETAIL"]["UF_NAME"]);

$APPLICATION->IncludeComponent(
	"akop:terminal.detail", 
	".default", 
	array(
		"ID" => CAkop::getRequest("id", true)
	)
);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>