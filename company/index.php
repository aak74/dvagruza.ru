<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Два груза. Перевози грузы дешевле");
$APPLICATION->SetPageProperty("keywords", "грузоперевозки, транспорт, сборные грузы");
// $APPLICATION->SetPageProperty("title", "Перевози грузы дешевле всех");
// $APPLICATION->SetTitle("Найди лучшую цену на перевозку сборного груза");
// CAkop::pr_var($_REQUEST, '$_REQUEST');
$xmlId = CAkop::getRequest("xml_id", true);



?>
<div class="container">
	<?
	if ( $xmlId ) {
		$APPLICATION->IncludeComponent(
			"akop:company.detail", 
			"", 
			array(
				"XML_ID" => $xmlId
			)
		);
	} else {
		$APPLICATION->IncludeComponent(
			"akop:company.list", 
			"", 
			array()
		);
	}
	?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>