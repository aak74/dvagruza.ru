<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Два груза. Перевози грузы дешевле");
$APPLICATION->SetPageProperty("keywords", "грузоперевозки, транспорт, сборные грузы, низкие цены на перевозку, перевозки дешево");
// $APPLICATION->SetPageProperty("title", "Перевози грузы дешевле всех");
$APPLICATION->SetTitle("Найди лучшую цену на перевозку сборного груза");
$APPLICATION->AddHeadScript("/js/calc.js");

$def = array(
	"from" => 632,
	"to" => 469,
	"volume" => 1,
	"weight" => 200,
);
foreach ($_REQUEST as $key => $value) {
	$def[$key] = CAkop::getRequest($key, true);
}

?>
<div class="main clearfix">
	<div id="calc-form" class="form-inline argo col-xs-6">
		<div class="from-to">
			<div>
				<div class="form-group form-group-lg">
					<div class="input-group">
						<div class="input-group-addon">Из</div>  
						<input type="text" class="form-control city" id="input-from" data-id="<?=$def["from"]?>" placeholder="Москва">
					</div>
					<div class="cities-wrapper">
					</div>
				</div>
			
			</div>
			<div>
				<button id="switch" class="btn btn-default btn-lg center-block"><span class="glyphicon glyphicon-sort" aria-hidden="true"></span></button>
			</div>
			<div>
				<div class="form-group form-group-lg">
					<div class="input-group">
						<div class="input-group-addon">В</div>  
						<input type="text" class="form-control city" id="input-to" data-id="<?=$def["to"]?>" placeholder="Екатеринбург">
					</div>  
					<div class="cities-wrapper">
					</div>
				</div>
			</div>
		</div>

		<div class="calc">
			<div class="cargo col-xs-6">
				<div class="form-group form-group-lg">
					<div class="input-group">
						<div class="input-group-addon">Вес, кг</div>  
						<input type="text" class="form-control" id="input-weight" value="<?=$def["weight"]?>" placeholder="200">
					</div>
				</div>
				<div class="form-group form-group-lg">
					<div class="input-group">
						<div class="input-group-addon">Объем, м3</div>  
						<input type="text" class="form-control" id="input-volume" value="<?=$def["volume"]?>" placeholder="1">
					</div>  
				</div>
			</div>

			<div class="search col-xs-6">
				<button id="search" class="btn btn-primary btn-lg">Найти лучшие<br/>предложения <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</div>
		</div>
	</div>
	<div class="companies col-xs-6">
		<h3>Расчет по данным компаний:</h3>
		<?
		$APPLICATION->IncludeComponent(
			"akop:company.list", 
			".default", 
			array()
		);
		?>
		<a href="/contacts/">Как попасть в этот список</a>
	</div>
</div>


<div class="result clearfix"></div>
<div class="log"></div>
<?
$APPLICATION->IncludeFile(
	"/include/disclaimer.php",
	false
);
?>

<div class="helper hidden">
<?
$APPLICATION->IncludeComponent(
	"akop:city.list", 
	".default", 
	array()
);
?>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>