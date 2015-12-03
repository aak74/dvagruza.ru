<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Два груза. Перевози грузы дешевле");
$APPLICATION->SetPageProperty("keywords", "грузоперевозки, транспорт, сборные грузы, низкие цены на перевозку, перевозки дешево");
// $APPLICATION->SetPageProperty("title", "Перевози грузы дешевле всех");
$APPLICATION->SetTitle("Перевози грузы дешевле");
$APPLICATION->AddHeadScript("/js/calc.js");

$cities = new CCity();
$arResult["ITEMS"] = $cities->getListMain(array("UF_NAME" => "asc"), array("!UF_NAME" => false));

?>
<div id="calc-form" class="form-inline clearfix">
  <div class="from-to">
    <div class="form-group form-group-lg">
      <div class="input-group">
        <div class="input-group-addon">Из</div>  
        <input type="text" class="form-control city" id="input-from" placeholder="Москва">
      </div>
      <div class="cities-wrapper">
      </div>
    </div>
    <button id="change" class="btn btn-default"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span></button>
    <div class="form-group form-group-lg">
      <div class="input-group">
        <div class="input-group-addon">В</div>  
        <input type="email" class="form-control city" id="input-to" placeholder="Екатеринбург">
      </div>  
      <div class="cities-wrapper">
      </div>
    </div>
  </div>

  <div class="calc">
    <div class="cargo col-xs-5">
      <div class="form-group form-group-lg">
        <div class="input-group">
          <div class="input-group-addon">Вес, кг</div>  
          <input type="text" class="form-control" id="input-from" placeholder="200">
        </div>
      </div>
      <div class="form-group form-group-lg">
        <div class="input-group">
          <div class="input-group-addon">Объем, м3</div>  
          <input type="email" class="form-control" id="input-volume" placeholder="1">
        </div>  
      </div>
    </div>

    <div class="search col-xs-7">
      <button id="search" class="btn btn-primary btn-lg">Найти <span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
    </div>
  </div>
</div>
<div class="log"></div>
<div class="helper hidden">
  <ul class="cities list-unstyled">
    <?foreach ($arResult["ITEMS"] as $item) :?>
      <li 
        data-id="<?=$item["ID"]?>"
        data-title="<?=strtolower($item["UF_NAME"])?>"
      ><?=$item["UF_NAME"]?></li>
    <?endforeach;?>
  </ul>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>