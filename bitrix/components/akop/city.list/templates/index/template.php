<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
// CAkop::pr_var($arResult, 'arResult');
?>
<ul class="cities list-unstyled">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<li
			data-title="<?=strtolower($item["UF_NAME_SHORT"])?>"
		>
			<span
				data-id="<?=$item["ID"]?>"
				data-name-lower="<?=strtolower( $item["UF_NAME_SHORT"] )?>"
				data-name="<?=$item["UF_NAME_SHORT"]?>"
			><?=$item["UF_NAME_SHORT"]?></span>
	  	</li>
	<?endforeach;?>
</ul>
