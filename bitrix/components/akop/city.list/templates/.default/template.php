<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
// CAkop::pr_var($arResult, 'arResult');
?>
<?
$APPLICATION->SetTitle("Города с терминалами крупнейших транспортных компаний");
// CAkop::pr_var($arResult, 'arResult');
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/include/goToCalc.php");?>
<div class="input-group">
	<input type="search" class="form-control" id="search-city-name" placeholder="Город" title="Введите первые буквы названия города">
	<div class="input-group-addon" id="clear-search" >
		<span class="glyphicon glyphicon-remove" aria-hidden="true" title="Очистить строку поиска"></span>
	</div>
</div> 		
<br>

<ul class="cities-list list-unstyled">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<li
			class="city"
			data-title="<?=strtolower($item["UF_NAME_SHORT"])?>"
			 data-name-lower="<?=strtolower($item["UF_NAME_SHORT"])?>"
		>
			<a
				href="/city/<?=$item["ID"]?>/"
				data-id="<?=$item["ID"]?>"
				data-name-lower="<?=strtolower( $item["UF_NAME_SHORT"] )?>"
				data-name="<?=$item["UF_NAME_SHORT"]?>"
			><?=$item["UF_NAME_SHORT"]?></a>
	  	</li>
	<?endforeach;?>
</ul>
