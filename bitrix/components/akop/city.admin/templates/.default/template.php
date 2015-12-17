<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
// CAkop::pr_var($arResult, 'arResult');
?>
<div class="admin-cities" data-path="<?=$this->__component->__path?>">
	<?if (is_array($arResult["ITEMS"]) && count($arResult["ITEMS"])) :?>
		<div class="parent col-md-2">
			<select id="cities-main" class="cities" size="30" multiple="multiple">
			  <?foreach ($arResult["ITEMS"] as $item) :?>
			  	<option 
			  		value="<?=$item["UF_NAME_SHORT"]?>"
			      	data-id="<?=$item["ID"]?>"
			    >
			    	<?=$item["UF_NAME_SHORT"]?>
			  	</option>
			  <?endforeach;?>
			</select>
		</div>
	<?endif;?>
	<div class="controls col-md-2">
		<a id="set-main-city" href="#" class="btn btn-success btn-block">Главный город</a>
		<a id="add-city" href="#" class="btn btn-default btn-block">Добавить &gt;&gt;</a>
		<a id="remove-city" href="#" class="btn btn-default btn-block">&lt;&lt; Удалить</a>
		<a id="get-city-from-all" href="#" class="btn btn-default btn-block" style="display: none;">Найти город</a>
	</div>
	<div class="terminals col-md-2">
			<select id="terminals-in-city" class="cities" size="30" multiple="multiple">
			</select>
	</div>
	<div id="log" class="log col-md-6">
	</div>
</div>