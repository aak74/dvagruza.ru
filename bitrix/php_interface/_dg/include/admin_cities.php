<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/iblock.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/prolog.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");
$APPLICATION->SetTitle("Управление городами");
// $APPLICATION->AddHeadString('<link rel="stylesheet" href="/bitrix/templates/dvagruza/bootstrap/css/bootstrap.min.css">', true);
$APPLICATION->AddHeadString('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">', true);
CJSCore::Init(array("jquery"));
// $APPLICATION->AddHeadString('<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>', true);
	
?>
<a href="<?=SITE_SERVER_NAME?>/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=10&type=references&lang=ru">Посмотреть справочники</a><br/>
<a id="update" href="#" class="btn btn-primary">Обновить</a>

<div class="cities">
<?
$APPLICATION->IncludeComponent(
	"akop:admin.cities",
	"",
	Array(),
	false

);
?>	
</div>


<div class="loading hidden">Идет обновление справочников...</div>
<div id="log"></div>
<style>
	#log {
    	font-size: 120%;
	}
</style>

<script>
	ref = {
		update: function(e) { 
	  	$("#log").text("");
			$(".loading").removeClass("hidden");
			$.post("/ajax/update_ref.php", {})
			  .done(function(data) {
				$(".loading").addClass("hidden");
			  	$("#log").html(data);
			  })
			  .fail(function() {
				$(".loading").addClass("hidden");
			  	$("#log").text("Ошибка обновление!");
			  });
		}
	}

	$(document).ready(function () {
		$("#update").click(ref.update);
	});	
</script>
