<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	$params = array(
   "senderCityId"=> 446,
   "receiverCityId"=> 473,
   // "receiverCityId"=> 463,
   "Cargos"=> array(array(
      // "length"=> 2, // для авиа перевозок обязательно
      // "width"=> 1,
      // "height"=> 1,
      "volume"=> 2,
      "weight"=> 250,
    ))
	);

  $tk = new CPecom();
  $result = $tk->_calc($params);
  CAkop::pr_var($result, 'result');

  // $comp = new CHLReference(2);
  // // $comp->getList();
  // $list = $comp->getList(array("UF_NAME" => "asc"));
  // CAkop::pr_var($list, 'list');
/*  

  $tk = new CDellin();
  $c = $tk->getCities();
  CAkop::pr_var($c, 'c');

  $tk = new CCompany("DELLIN");
  // $result = $tk->calc($params);
  $result = $tk->getField("UF_NAME");
  CAkop::pr_var($result, 'result');
  $result = $tk->getField("UF_HASH");
  CAkop::pr_var($result, 'result');
  */
?>