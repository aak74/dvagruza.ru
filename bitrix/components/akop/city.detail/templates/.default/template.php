<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$APPLICATION->SetTitle("В городе " . $arResult["DETAIL"]["UF_NAME_FULL"] . " есть терминалы транспортных компаний:");
// CAkop::pr_var($arResult["DETAIL"], 'arResult');
?>

<h2></h2>
<div class="terminals panel-group container" id="accordion" role="tablist" aria-multiselectable="true">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading<?=$item["COMPANY_XML_ID"]?>">
		    	<h4 class="panel-title">
		    		<a
					 	href="/company/<?=$item["COMPANY_XML_ID"]?>/"
						data-id="<?=$item["COMPANY_XML_ID"]?>"
						data-title="<?=$item["COMPANY_NAME"]?>"
		    		><?=$item["COMPANY_NAME"]?></a>
					<a 
						class="collapsed" role="button" 
						href="#collapse<?=$item["COMPANY_XML_ID"]?>" 
						data-toggle="collapse" 
						data-parent="#accordion" 
						aria-expanded="false" 
						aria-controls="collapse<?=$item["COMPANY_XML_ID"]?>"
					>
			    		<span>(<?=count($item["TERMINALS"])?>)</span>
						<span class="caret"></span>
			        </a>
		       </h4>
	       </div>
	        <div id="collapse<?=$item["COMPANY_XML_ID"]?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$item["COMPANY_XML_ID"]?>" aria-expanded="false">
	            <div class="panel-body">
					<ul>
						<?foreach ($item["TERMINALS"] as $terminal) :?>
					  		<li
					  			data-title="<?=strtolower($terminal["NAME"])?>"
					  		>
					  			<a
					  				href="/terminal/<?=$terminal["ID"]?>/"
					  				data-id="<?=$terminal["ID"]?>"
					  				data-title="<?=$terminal["NAME"]?>"
								><?=$terminal["NAME"]?></a>

					  		</li>
						<?endforeach;?>
					</ul>
				</div>
			</div>
	  	</div>
	<?endforeach;?>
</div>
<?include($_SERVER["DOCUMENT_ROOT"]."/include/goToCalc.php");?>