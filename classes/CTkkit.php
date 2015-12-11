<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CTkkit extends CCalc{
	const 
		COMPANY_ID = 2,
		API_BASE_URL = 'http://tk-kit.ru/API.1/';

	// public function __construct() {
	// }
	
	public function calc($params) {
		if ($params && is_array($params)) {
			$city = new CCity();
			$from = $city->getItem(array("ID" => $params["from"]));
			$to = $city->getItem(array("ID" => $params["to"]));

			 

			$p = array(
				"derivalPoint" => $from["UF_XML_ID"], // код КЛАДР пункта отправки  (обязательное поле)
				"arrivalPoint" => $to["UF_XML_ID"], // код КЛАДР пункта прибытия (обязательный параметр)
				"sizedVolume" =>  $params["volume"], // общий объём груза в кубических метрах (обязательный параметр)
				"sizedWeight" =>  $params["weight"] // общий вес груза в килограммах (обязательный параметр)
			);
			// CAkop::pr_var($p, 'p');

			/* Запрос к серверу Деловых линий для расчета цены.
			 * Возвращает довольно много данных. Для начала возьмем только цену и срок доставки.
			 */
			$res = $this->_call('v1/public/calculator.json', $p);
			// CAkop::pr_var($res, 'res');
			if ( is_array($res) ) {
				$result = array(
					"price" => $res["price"],
					"time" => $res["time"]["value"],
					"from" => $res["derival"]["terminals"],
					"to" => $res["arrival"]["terminals"],
					"air" => $res["air"],
				);
			} else {
				$result = false;
			}
		} else {
			$result = false;
		}
		return $result;
	}
	
	/** Обновляем города по базе Деловых линий, как наиболее продвинутых в поане API */
	public function updateTerminals() {
		$list = $this->_getTerminals();
		CAkop::pr_var($list, '$list');
// return;
		$city = new CCity();
		$terminal = new CTerminal();

		// в массиве сначала города, а внутри них терминалы
		foreach ($list as $cityItem) {
			$name = $cityItem[0]["ORT01"];
			// ищем город
			$cItem = $city->getItem( array("UF_NAME_SHORT" => $name) );
			// $cityId = $cItem["ID"];
			foreach ($cityItem as $terminalItem) {
				// добавляем терминал
				$filter = array(
					"UF_XML_ID" => $terminalItem["WERKS"],
					"UF_COMP_ID" => self::COMPANY_ID,
				);

				$params = array(
					"UF_NAME" => $terminalItem["WERKS_NAME"],
					"UF_COMP_ID" => self::COMPANY_ID,
					"UF_CITY_ID" => $cItem["ID"],
					"UF_ADDRESS" => $terminalItem["STRAS"],
					"UF_PHONES" => $terminalItem["TEL_NUMBER"],
					"UF_ZIP" => $terminalItem["PSTLZ"],
					"UF_XML_ID" => $terminalItem["WERKS"],
					// "UF_LONGITUDE" => $terminalItem["longitude"],
					// "UF_LATITUDE" => $terminalItem["latitude"],
				);

				$id = $terminal->updateEx($filter, $params);
				// если город найден и он неактивен, то нужно добавить ему активность
				if ( $cItem["ID"] && ($cItem["UF_ACTIVE"] == false) ) {
					$city->setActive($cItem["ID"]);
					
				}

			}
		}
	}


	/** Выдает терминалы компании. Внутри каждого города есть массив terminals, в которых перечислены все терминалы
	 * Териминалов в городе может быть более одного
	 */
	public function _getTerminals() {
		$res = $this->_call('?f=get_rp');
		return $res;
	}

	
	public function getCities() {
		$list = $this->_getCities();
		foreach ($list as $cityId => $city) {
			$result[$cityId] = array(
				"ID" => $cityId,
				"NAME" => $city[0]["WERKS_NAME"],
				"ZIP" => $city[0]["PSTLZ"],
				"STATE" => $city[0]["LAND1"],
				"ADDRESS" => $city[0]["STRAS"],
				"TR_ZONE" => $city[0]["TRANSPZONE"],
			);
		}

		return $result;
	}

	private function _getCities() {
		echo 'getCities() {';
		return $this->_call( "?f=get_rp" );

/*
    [020000100000] => Array
        (
            [0] => Array
                (
                    [WERKS] => 0201
                    [LAND1] => RU
                    [WERKS_NAME] => Уфа
                    [PSTLZ] => 450103
                    [REGIO] => 02
                    [ORT01] => Уфа
                    [STRAS] => Пугачева 300/1
                    [ZSCHWORK] => ПН-ПТ 9.00-19.00, СБ 9.00-17.00
                    [ZALTAD] => 
                    [STREETCODE] => 000000005836
                    [TRANSPZONE] => 0000000200
                    [TEL_NUMBER] => +73472242684
                    [TEL_EXTENS] => 
                    [REMARK] => 
                    [EKIT] => X
                    [ZONE] => 
                    [ZONE_NAME] => 		
*/                    
		// return $this->_call( "", array("f" => "get_rp") );
	}
	protected function _call($url, $params = array()) {
	// private function _call($url, $params = array()) {
		CAkop::pr_var($params, 'CKIT params');

		return parent::_call(self::API_BASE_URL . $url, $params);
	}
}
?>