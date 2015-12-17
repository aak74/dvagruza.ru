<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="terminal-detail">

<?
$APPLICATION->SetTitle($arResult["COMPANY"]["UF_NAME"] . " - ". $arResult["DETAIL"]["UF_NAME"]);
// CAkop::pr_var($arResult, 'arResult');
?>
<a href="/company/<?=$arResult["COMPANY"]["UF_XML_ID"]?>/">все терминалы <?=$arResult["COMPANY"]["UF_NAME"]?></a>

<table class="table table-hover">
	<tr>
		<td>Адрес</td>
		<td><?=$arResult["DETAIL"]["UF_ADDRESS"]?></td>
	</tr>
	<tr>
		<td>Телефоны</td>
		<td><?=$arResult["DETAIL"]["UF_PHONES"]?></td>
	</tr>
	<tr>
		<td>Широта</td>
		<td><?=$arResult["DETAIL"]["UF_LATITUDE"]?></td>
	</tr>
	<tr>
		<td>Долгота</td>
		<td><?=$arResult["DETAIL"]["UF_LONGITUDE"]?></td>
	</tr>
</table>
<a href="/" class="btn btn-lg btn-primary">
	<span class="glyphicon glyphicon-rub" aria-hidden="true"></span> Перейти к расчету перевозки
</a>
</div>
