<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CDellinException extends Exception {
}

class CDellin extends CCalc{
	const 
		COMPANY_ID = 3,
		KEY = 'BB0BAD88-756F-11E5-A6BB-00505683A6D3',
		API_BASE_URL = 'https://api.dellin.ru/';

	// public function __construct() {
	// }
	
	public function calc($params) {
		if ($params && is_array($params)) {
			$city = new CCity();
			$from = $city->getItem(array("ID" => $params["from"]));
			$to = $city->getItem(array("ID" => $params["to"]));

			 

			$p = array(
				"derivalPoint" => $from["UF_KLADR"], // код КЛАДР пункта отправки  (обязательное поле)
				"arrivalPoint" => $to["UF_KLADR"], // код КЛАДР пункта прибытия (обязательный параметр)
				"sizedVolume" =>  $params["volume"], // общий объём груза в кубических метрах (обязательный параметр)
				"sizedWeight" =>  $params["weight"], // общий вес груза в килограммах (обязательный параметр)
				"quantity" => 100 // для того, чтобы не считалось для одного места, В противном случае может вылезти негабарит
			);
			// CAkop::pr_var($p, 'p');
			// return;
			/* Запрос к серверу Деловых линий для расчета цены.
			 * Возвращает довольно много данных. Для начала возьмем только цену и срок доставки.
			 */
			$res = $this->_call('v1/public/calculator.json', $p);
			// CAkop::pr_var($res, 'res');
			if ( is_array($res) ) {
				$result = array(
					"price" => number_format($res["price"], 2, '.', ''),
					"time" => $res["time"]["value"],
					// "from" => $res["derival"]["terminals"], // Пока не возвращаем список терминалов
					// "to" => $res["arrival"]["terminals"], // Пока не возвращаем список терминалов
					"air" => $res["air"],
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
	

	public function updateTerminals() {
		$list = $this->_getTerminals();
		// CAkop::pr_var($list, '$list');
// return;
		$city = new CCity();
		$terminal = new CTerminal();

		// в массиве сначала города, а внутри них терминалы
		foreach ($list as $cityItem) {
			$name = $cityItem["name"];
			// ищем город
			$cItem = $city->getItem( array("UF_KLADR" => $cityItem["code"]) );
			$cityId = $cItem["ID"];
			foreach ($cityItem["terminals"]["terminal"] as $terminalItem) {
				// добавляем терминал
				$filter = array(
					"UF_XML_ID" => $terminalItem["id"],
					"UF_COMP_ID" => self::COMPANY_ID,
				);

				$params = array(
					"UF_NAME" => $terminalItem["name"],
					"UF_COMP_ID" => self::COMPANY_ID,
					"UF_CITY_ID" => $cItem["ID"],
					"UF_ADDRESS" => $terminalItem["address"],
					// "UF_PHONES" => $terminalItem[""],
					"UF_ZIP" => $terminalItem["postalCode"],
					"UF_XML_ID" => $terminalItem["id"],
					"UF_LONGITUDE" => $terminalItem["longitude"],
					"UF_LATITUDE" => $terminalItem["latitude"],
				);

				$id = $terminal->updateEx($filter, $params);
				// если город найден и он неактивен, то нужно добавить ему активность
				if ( $cItem["ID"] && ($cItem["UF_ACTIVE"] == false) ) {
					$city->setActive($cItem["ID"]);
					
				}


			}

		}
	}


	/** Обновляем города по базе Деловых линий, как наиболее продвинутых в поане API */
	public function updateTerminalsOld() {
		// получаем список городов
		$c = $this->getCities();
		/** по hash определяем изменилось ли что-то в их структуре
		 * если изменилось, тогда будем читать список терминалов в json
		 */
		$tk = new CCompany("DELLIN");
		$tkId = $tk->getField("ID");
		echo 1;
		// $hash = ;
		if ($tk->getField("UF_HASH") !== $c->hash) {
			echo 2;
			$city = new CCityOld();
			$branch = new CBranch();
			$terminals = $this->_getTerminals();

			// CAkop::pr_var($terminals, 'terminals');
			foreach ($terminals as $terminal) {
				$cityFilter = array("UF_NAME" => $terminal["name"]);
				$cityId = $city->updateEx(
					$cityFilter, 
					array_merge(
						$cityFilter,
						array(
							"UF_XML_ID" => $terminal["code"],
							"UF_TIMESHIFT" => $terminal["timeshift"],
							"UF_LATITUDE" => $terminal["latitude"],
							"UF_LONGITUDE" => $terminal["longitude"],
						)
					)
				);

				echo $terminal["name"], " - ", $cityId,   "<br>";
				
				$branchFilter = array(
					"UF_CITY_ID" => $cityId,
					"UF_COMP_ID" => $tkId
				);
				$branchParams = array(
					"UF_ADDRESS" => $terminal["terminals"]["terminal"][0]["fullAddress"],
					// "UF_BRANCH_PHONES" => $city["title"],
					"UF_LATITUDE" => $terminal["latitude"],
					"UF_LONGITUDE" => $terminal["longitude"],
					"UF_XML_ID" => $terminal["cityID"],
				);
				
				$branchId = $branch->updateEx(
					$branchFilter, 
					array_merge(
						$branchFilter,
						$branchParams
					)
				);
				

			}
		}

		
 /*
		{
			"hash": "b38dc7ec0cfbfa63d8734caa9d53ae8fbcf9a39b1b793c57e2ec19694dd14408",
			"url": "http://api.dellin.ru/catalog/cities.csv?sk=6d3oAGj2_o9SYtWdqft7lw&e=1445174049"
		}
*/
	}


	/** Выдает терминалы компании. Внутри каждого города есть массив terminals, в которых перечислены все терминалы
	 * Териминалов в городе может быть более одного
	 */
	public function _getTerminals() {
		$res = $this->_call('v2/public/terminals.json');
		return $res["city"];
	}

	public function getCities() {
		return $this->_call('v1/public/cities.json');
	}

	public function getPlaces() {
		return $this->_call('v1/public/places.json');
	}

	protected function _call($url, $params = array()) {
		
		$params["appKey"] = self::KEY;

		$options = array(
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_POST => TRUE,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_ENCODING =>   'gzip',
			CURLOPT_URL => self::API_BASE_URL . $url,
			CURLOPT_POSTFIELDS => json_encode($params),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json; charset=utf-8',
			)
		);

		// CAkop::pr_var($options, 'options');
		// CAkop::pr_var($params, 'params');
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new CDellin(curl_error($ch));
		}
		curl_close($ch);
		return json_decode($result, true);
	}
}
?>