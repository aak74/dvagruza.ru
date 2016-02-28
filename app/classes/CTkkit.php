<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CTkkit extends CCalc{
	const 
		COMPANY_ID = 2,
		API_BASE_URL = 'http://tk-kit.ru/API.1/';

	// public function __construct() {
	// }
	
	public function calc($params) {
		/* http://tk-kit.ru/API.1/?f=price_order
		WEIGHT=30
		VOLUME=0.6
		SLAND=RU
		SZONE=0000008610 Отправка из - Транспортная зона (см. описание функции get_city_list поле TZONEID)
		SCODE=860001000000 Отправка из - Код населённого пункта (см. описание функции get_city_list поле ID)
		RLAND=RU
		RZONE=0000008910
		RCODE=890000700000
		PRICE=
		WAERS=RUB
		*/
		if ($params && is_array($params)) {
			// Получаем данные о параметрах городов отправления и прибытия
			$city = new CCityComp();
			$from = $city->getItem( array("UF_CITY_ID" => $params["from"], "UF_COMP_ID" => self::COMPANY_ID) );
			$to = $city->getItem( array("UF_CITY_ID" => $params["to"], "UF_COMP_ID" => self::COMPANY_ID) );

			$p = array_merge(
				array(
					// "f" => "price_order",
					"VOLUME" => $params["volume"],
					"WEIGHT" => $params["weight"],
					"PRICE" => 10000,
					"WAERS" => "RUB"
				),
				$this->_getParams4Calc($from["UF_EXTRA_DATA"], "S"),
				$this->_getParams4Calc($to["UF_EXTRA_DATA"], "R")
			);
			// CAkop::pr_var($p, 'p');
			// return;

			// Очистим память перед запросом
			unset($city);
			unset($from);
			unset($to);
			unset($params);

			/* Запрос к серверу Деловых линий для расчета цены.
			 * Возвращает довольно много данных. Для начала возьмем только цену и срок доставки.
			 */
			$res = $this->_call("?f=price_order", $p);
			// CAkop::pr_var($res, 'res');

			// Если не ошибка и ответ читаемый, то соберем ответ с нужными данными
			if ( is_array($res) && !isset($res["error"]) ) {
				// Можно получить больше данных. Для этого необходимо запросить функции класса CTerminal
				$result = array(
					"price" => number_format($res["PRICE"]["TOTAL"], 2, '.', ''),
					"time" => $res["DAYS"],
					// "from" => $res["derival"]["terminals"],
					// "to" => $res["arrival"]["terminals"],
					// "air" => $res["air"],
					"response" => $res
				);
			} else {
				$result = false;
			}
		} else {
			$result = false;
		}
		return $result;
	}
	
	// Обновление данных о терминалах ТК
	public function updateTerminals() {
		$list = $this->_getTerminals();
		// CAkop::pr_var($list, '$list');
// return;
		$city = new CCity();
		$cityComp = new CCityComp();
		$terminal = new CTerminal();

		// в массиве сначала города, а внутри них терминалы
		foreach ($list as $cityKey => $cityItem) {
			$name = $cityItem[0]["ORT01"];
			// ищем город
			$cItem = $city->getItem( array("UF_NAME_SHORT" => $name) );
			// $cityId = $cItem["ID"];

			/* Для каждого города надо сохранить значения, которые понадобятся для расчета стоимости перевозки */
			$filter = array(
				"UF_CITY_ID" => $cItem["ID"],
				"UF_COMP_ID" => self::COMPANY_ID,
			);

			$params = array_merge(
				$filter,
				array(
					"UF_EXTRA_DATA" => serialize(array(
						"CODE" => $cityKey,
						"ZONE" => $cityItem[0]["TRANSPZONE"],
						"LAND" => $cityItem[0]["LAND1"],
					))
				)
			);

			$cityComp->updateEx($filter, $params);

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

/*	
	Стандартную обработку убираю, потому что некоторые функции принимают только GET запросы
	protected function _call($url, $params = array()) {
	// private function _call($url, $params = array()) {
		CAkop::pr_var($params, 'CKIT params');

		return parent::_call(self::API_BASE_URL . $url, $params);
		// return $this->_call(self::API_BASE_URL . $url, $params);
	}
*/

	// Из сериализованного массива возвращает массив для запроса стоимости перевозки
	private function _getParams4Calc($params, $add) {
		$params = unserialize($params);
		foreach ($params as $key => $value) {
			$result[$add . $key] = $value;
		}
		return $result;
	}

	protected function _call($url, $params = array()) {
		// CAkop::pr_var($params, 'params');
		// $str = "";

		/* Доформировываем URL переданными параметрами. Некоторые функции принимают только GET запросы, 
		 * поэтому использовать POST запросы не представляется возможным
		 */
		if ( is_array($params) ) {
			foreach ($params as $key => $value) {
				$url .= "&" . $key . "=" . $value;
			}
		}

		$options = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			// CURLOPT_POST => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_ENCODING =>   'gzip',
			CURLOPT_URL => self::API_BASE_URL . $url,
			// CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json; charset=utf-8',
			)
		);

		// CAkop::pr_var($options, 'options');
		// CAkop::pr_var($params, 'params');
        $log = new CLog("/upload/log/tk-kit/");
        $log->add2Log(
            "query:"  . PHP_EOL
            . $url
        );
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
        $log->add2Log(
            "result:"  . PHP_EOL
            . $result
        );

		if (curl_errno($ch)) {
			throw new CCalcException(curl_error($ch));
		}
		curl_close($ch);
		return json_decode($result, true);
	}

}
?>