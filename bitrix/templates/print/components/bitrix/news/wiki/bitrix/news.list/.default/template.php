<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-list">
<table class="table table-condensed">
	<thead>
		<tr>
			<td>Филиал</td><td>Адрес</td><td>Телефоны</td><td>email</td><td>Режим работы</td><td>Ссылка на сайт</td>
		</tr>
	</thead>
	<tbody>
		<?foreach($arResult["ITEMS"] as $arItem):?>
					<tr>
						<td><?=$arItem["NAME"]?></td><td><?=$arItem["PROPERTIES"]["ADDRESS"]["VALUE"]?></td>
						<td>
							<?foreach ($arItem["PROPERTIES"]["PHONES"]["VALUE"] as $phone) : ?>
							<?=$phone?><br>
							<?endforeach;?>
						</td>
						<td><?=$arItem["PROPERTIES"]["EMAIL"]["VALUE"]?></td><td><?=$arItem["PROPERTIES"]["SCHEDULE"]["VALUE"]?></td><td><a href="http://tk-kit.ru<?=$arItem["PREVIEW_TEXT"]?>"><?=$arItem["NAME"]?></a></td>
					</tr>
		<?endforeach;?>
	</tbody>
</table>
</div>
