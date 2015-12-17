<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="company-detail">

<?
$APPLICATION->SetTitle($arResult["DETAIL"]["UF_NAME"]);
// CAkop::pr_var($arResult["DETAIL"], 'arResult');
?>
<a href="/" class="btn btn-lg btn-primary">
	<span class="glyphicon glyphicon-rub" aria-hidden="true"></span> Перейти к расчету перевозки
</a>
<p>Перейти на <a href="//<?=$arResult["DETAIL"]["UF_SITE"]?>" target="_blank" rel="nofollow">сайт компании</a></p>
<h2>Терминалы (<?=count($arResult["ITEMS"])?>):</h2>
</div>
<ul class="terminals list-unstyled">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<li
			data-title="<?=strtolower($item["UF_NAME"])?>"
		>
			<a
				href="/terminal/<?=$item["ID"]?>/"
				data-id="<?=$item["ID"]?>"
				data-title="<?=$item["UF_NAME"]?>"
			><?=$item["UF_NAME"]?></a>
	  	</li>
	<?endforeach;?>
</ul>
