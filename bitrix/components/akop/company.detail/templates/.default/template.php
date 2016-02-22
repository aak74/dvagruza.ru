<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="company-detail">

<?
$APPLICATION->SetTitle($arResult["DETAIL"]["UF_NAME"]);
// CAkop::pr_var($arResult["DETAIL"], 'arResult');
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/include/goToCalc.php");?>
<p>Перейти на <a href="//<?=$arResult["DETAIL"]["UF_SITE"]?>" target="_blank" rel="nofollow">сайт компании</a></p>
<h2>Города с терминалами (<?=count($arResult["ITEMS"])?>):</h2>
</div>

<div class="terminals panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?foreach ($arResult["ITEMS"] as $item) :?>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="heading<?=$item["ID"]?>">
		    	<h4 class="panel-title">
		    		<a
					 	href="/city/<?=$item["ID"]?>/"
						data-id="<?=$item["ID"]?>"
						data-title="<?=$item["NAME"]?>"
		    		><?=$item["NAME"]?></a>
					<a 
						class="collapsed" role="button" 
						href="#collapse<?=$item["ID"]?>" 
						data-toggle="collapse" 
						data-parent="#accordion" 
						aria-expanded="false" 
						aria-controls="collapse<?=$item["ID"]?>"
					>
		    			<span>(<?=count($item["TERMINALS"])?>)</span>
						<span class="caret"></span>
			        </a>
		       </h4>
	       </div>
	        <div id="collapse<?=$item["ID"]?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$item["ID"]?>" aria-expanded="false">
	            <div class="panel-body">
					<ul>
						<?foreach ($item["TERMINALS"] as $terminal) :?>
					  		<li
					  			data-title="<?=strtolower($terminal["UF_NAME"])?>"
					  		>
					  			<a
					  				href="/terminal/<?=$terminal["ID"]?>/"
					  				data-id="<?=$terminal["ID"]?>"
					  				data-title="<?=$terminal["UF_NAME"]?>"
								><?=$terminal["UF_NAME"]?></a>

					  		</li>
						<?endforeach;?>
					</ul>
				</div>
			</div>
	  	</div>
	<?endforeach;?>
</div>