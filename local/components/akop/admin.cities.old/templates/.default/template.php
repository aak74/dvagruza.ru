<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="admin-cities" data-path="<?=$this->__component->__path?>">
	<?if (is_array($arResult["ITEMS"]) && count($arResult["ITEMS"])) :?>
		<div class="parent col-md-2">
			<select id="cities-main" class="cities" size="30" multiple="multiple">
			  <?foreach ($arResult["ITEMS"] as $item) :?>
			  	<option 
			  		value="<?=$item["UF_NAME"]?>"
			      data-id="<?=$item["ID"]?>"
			    >
			    	<?=$item["UF_NAME"]?>
			  	</option>
			  <?endforeach;?>
			</select>
		</div>
	<?endif;?>
	<div class="controls col-md-2">
		<a id="set-main-city" href="#" class="btn btn-success btn-block">Главный город</a>
		<a id="add-city" href="#" class="btn btn-default btn-block">Добавить &gt;&gt;</a>
		<a id="remove-city" href="#" class="btn btn-default btn-block">&lt;&lt; Удалить</a>
	</div>
	<div class="children col-md-2">
			<select id="cities-children" class="cities" size="30" multiple="multiple">
			</select>
	</div>
</div>