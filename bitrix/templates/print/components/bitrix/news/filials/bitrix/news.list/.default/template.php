<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-list">
<table class="table table-condensed">
	<thead>
		<tr>
			<td>Филиал</td><td>Адрес</td><td>Телефоны</td><td>email</td><td>Режим работы</td>
		</tr>
	</thead>
	<tbody>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<tr>
				<td><a href="/filials/detail.php?name=<?=$arItem["PREVIEW_TEXT"]?>"><?=$arItem["NAME"]?></a></td>
				<td><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></td>
				<td>
					<?foreach ($arItem["PROPERTIES"]["PHONES"]["VALUE"] as $phone) : ?>
					<?=$phone?><br>
					<?endforeach;?>
				</td>
				<td><?=$arItem["PROPERTIES"]["EMAIL"]["VALUE"]?></td><td><?=$arItem["PROPERTIES"]["SCHEDULE"]["VALUE"]?></td>
			</tr>
		<?endforeach;?>
	</tbody>
</table>
</div>
