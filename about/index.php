<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О сервисе");
?>
<div class="container">
	<?
	$APPLICATION->IncludeFile(
		"/include/disclaimer.php",
		false
	);
	?>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>