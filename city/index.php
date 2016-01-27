<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Два груза. Перевози грузы дешевле");
$APPLICATION->SetPageProperty("keywords", "грузоперевозки, транспорт, сборные грузы");
// $APPLICATION->SetPageProperty("title", "Перевози грузы дешевле всех");
// $APPLICATION->SetTitle("Найди лучшую цену на перевозку сборного груза");
// CAkop::pr_var($_REQUEST, '$_REQUEST');
?>
<?
$APPLICATION->IncludeComponent(
	"akop:city.detail", 
	".default", 
	array(
		"ID" => CAkop::getRequest("id", true)
	)
);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>