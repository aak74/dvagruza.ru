<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
// CAkop::pr_var($arResult, 'arResult');
?>
<ul class="company-list list-unstyled">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<li>
			<a
				href="/company/<?=$item["UF_XML_ID"]?>/"
				data-id="<?=$item["ID"]?>"
				data-name="<?=$item["UF_NAME"]?>"
				data-site="<?=$item["UF_SITE"]?>"
			><?=$item["UF_NAME"]?></a>
	  	</li>
	<?endforeach;?>
</ul>
