<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

		<div class="clearfix"></div>
		<?=$APPLICATION->GetMenuHtmlEx("bottom", false, SITE_TEMPLATE_PATH . "/bottom.menu_template.php");?>
	</div>
<?include($_SERVER["DOCUMENT_ROOT"]."/app/include/counter.php");?>
<?include($_SERVER["DOCUMENT_ROOT"]."/app/include/scripts.php");?>
</body>
</html>