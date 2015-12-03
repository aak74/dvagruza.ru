<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CPecom {
	const 
		LOGIN = 'ak74',
		KEY = '16351BB897654D2A119E938565F0E4BAB1AD6665';

  // public function __construct() {
  // }
  
  public function calc($params) {
/*  $params = array(
   "senderCityId"=> 446,
   "receiverCityId"=> 463,
   "Cargos"=> array(array(
      "length"=> 2, // для авиа перевозок обязательно
      "width"=> 1, // для авиа перевозок обязательно
      "height"=> 1, // для авиа перевозок обязательно
      "volume"=> 2,
      "weight"=> 100,
    ))
  );
*/    
    $result = $this->_call('calculator', 'calculateprice', $params);
    // TODO обработать вывод для общепринятого
    return $result;
  }
  
  /* Выдает терминалы компании. Внутри каждого города есть массив cities городов, в которые осуществляется доставка */
  public function getTerminals() {
    return $this->_call('branches', 'all', null);
  }

  private function _call($group, $method, $params) {
		$sdk = new PecomKabinet(self::LOGIN, self::KEY);
		$result = $sdk->call($group, $method, $params);
		$sdk->close();
    // CAkop::pr_var($result);
		return $result;
  }
}
?>