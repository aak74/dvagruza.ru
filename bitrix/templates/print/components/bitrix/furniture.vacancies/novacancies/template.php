<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (count($arResult['ITEMS']) == 0):?>
	<p>В настоящий момент вакансий нет!</p>
<?else:?>
	<a name="top"></a>	
	<?if (count($arResult['ITEMS']) > 1):?>
		<ul>
		<?foreach ($arResult['ITEMS'] as $key=>$val):?>
			<li class="point-faq"><a href="#<?=$val["ID"]?>"><?=$val['NAME']?></a></li>
		<?endforeach;?>
		</ul>
	<?endif;?>

	<?foreach ($arResult['ITEMS'] as $key=>$val):?>
		<?
			$this->AddEditAction($val['ID'],$val['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($val['ID'],$val['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('FAQ_DELETE_CONFIRM', array("#ELEMENT#" => CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_NAME")))));
		?>
 		<?if (count($arResult['ITEMS']) > 1):?>
			<div class="hr"></div>
		<?endif;?>
		<div id="<?=$this->GetEditAreaId($val['ID']);?>">
			<a name="<?=$val["ID"]?>"></a>
			<h3><?=$val['NAME']?></h3>
			<p>
				<?=$val['DETAIL_TEXT']?>
			</p><p>
				<a href="#top"><?=GetMessage("SUPPORT_FAQ_GO_UP")?></a>
			</p>
		</div>
	<?endforeach;?>
<?endif;?>