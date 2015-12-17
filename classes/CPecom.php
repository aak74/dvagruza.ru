<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CPecom extends CCalc{
	const 
		COMPANY_ID = 1,
		LOGIN = 'ak74',
		KEY = '16351BB897654D2A119E938565F0E4BAB1AD6665';

	// public function __construct() {
	// }
	
	public function calc($params) {
	    if ($params && is_array($params)) {
			// $from = $this->_getCityId( $params["from"] );
			// $to = $this->_getCityId( $params["to"] );

			$city = new CCityComp();
			$from = $city->getItem( array("UF_CITY_ID" => $params["from"], "UF_COMP_ID" => self::COMPANY_ID) );
			$to = $city->getItem( array("UF_CITY_ID" => $params["to"], "UF_COMP_ID" => self::COMPANY_ID) );

			// CAkop::pr_var($params, '$params');
			$p = array(
			 "senderCityId" => $from["UF_EXTRA_DATA"],
			 "receiverCityId" => $to["UF_EXTRA_DATA"],
			 "Cargos" => array(
			 	array(
					// "length"=> 2, // для авиа перевозок обязательно
					// "width"=> 1, // для авиа перевозок обязательно
					// "height"=> 1, // для авиа перевозок обязательно
					"volume" => $params["volume"],
					"weight" => $params["weight"],
				))
			);
			
			// CAkop::pr_var($p, '$params');
			$res = $this->_calc($p);

		// CAkop::pr_var($res, '$res');

		    if ( is_array($res) && empty( $res["error"] ) ) {
		        $result = array(
					"price" => number_format($res["transfers"][0]["costTotal"], 2, '.', ''),
		          	"time" => implode("-", $res["commonTerms"][0]["transporting"]),
		          	// "from" => $res["derival"]["terminals"],
		          	// "to" => $res["arrival"]["terminals"],
		          	"air" => $res["transfers"][1]["costTotal"],
		        );
	        } else {
		        $result = false;
	        }
	    } else {
	      $result = false;
	    }
		// CAkop::pr_var($result, '$result');
	    return $result;
	}
	
	/* Выдает терминалы компании. Внутри каждого города есть массив cities городов, в которые осуществляется доставка */
	public function getCities() {
	}

	public function updateTerminals() {
		$list = $this->getTerminals();

// 		CAkop::pr_var($list, 'updateTerminals list');
// return;
		$city = new CCity();
		$cityComp = new CCityComp();
		$terminal = new CTerminal();

		foreach ($list["branches"] as $item) {

			$name = $item["title"];
		
			// ищем терминал
			$term = $terminal->getItem( array(
				"UF_XML_ID" => $item["bitrixId"],
				"UF_COMP_ID" => self::COMPANY_ID,
			) );

			if ( $terminalId = $term["ID"]) {
				$cityId = $term["UF_CITY_ID"];
				echo '$cityId = ', $cityId, "<br>";
			} else {

				// ищем город по названию
				$cItem = $city->getItem(array("UF_NAME_SHORT" => $name));
				$cityId = $cItem["ID"];
			}

			// добавляем терминал
			// $filter = array(
			// 	"UF_XML_ID" => $item["bitrixId"],
			// 	"UF_COMP_ID" => self::COMPANY_ID,
			// );

			$params = array(
				"UF_NAME" => $name,
				"UF_COMP_ID" => self::COMPANY_ID,
				"UF_CITY_ID" => $cityId,
				"UF_ADDRESS" => $item["address"],
				// "UF_PHONES" => $item[""],
				"UF_ZIP" => $item["postalCode"],
				"UF_XML_ID" => $item["bitrixId"],
				// "UF_LONGITUDE" => $item[""],
				// "UF_LATITUDE" => $item[""],
			);

			// Если терминал был ранее найден, то обновим данные. В противном случае добавляем.
			if ( $terminalId ) {
				$id = $terminal->update($terminalId, $params);
			} else {
				$id = $terminal->add($params);
			}

			/* Для каждого города надо сохранить значения, которые понадобятся для расчета стоимости перевозки */
			$filter = array(
				"UF_CITY_ID" => $cityId,
				"UF_COMP_ID" => self::COMPANY_ID,
			);

			$params = array_merge(
				$filter,
				array(
					"UF_EXTRA_DATA" => $item["bitrixId"],
				)
			);

			$cityComp->updateEx($filter, $params);


			// если город найден и он неактивен, то нужно добавить ему активность
			if ( $cItem["ID"] && ($cItem["UF_ACTIVE"] == false) ) {
				$city->setActive($cItem["ID"]);
				
			}

		}

	}

	public function getTerminals() {
		return $this->_call('branches', 'all', null);
	}

	public function _calc($params) {
		$result = $this->_call('calculator', 'calculateprice', $params);
/*		CAkop::pr_var(array(
			'$params' => $params,
			'$res' => $res
		));
*/			
		return $result;
	}

	private function _getCityId($id) {
		$branch = new CBranch();
		$branch = $branch->getItem( array( "UF_CITY_ID" => $id, "UF_COMP_ID" => self::COMPANY_ID ) );

		if (!$branch) {

		// } else {
			$city = new CCity();
			$list = $city->getList(array("ID" => "asc"), array("!UF_NAME" => false, "UF_PARENT" => $id));
			// CAkop::pr_var($list, '_getCity list');
			$city = current($list);
			// CAkop::pr_var($city, '_getCity city');
			$branch = new CBranch();
			$branch = $branch->getItem( array( "UF_CITY_ID" => $city["ID"] ) );
		}

		// CAkop::pr_var($branch, '_getCity branch');
		return $branch["UF_XML_ID"];
	}

	protected function _call($group, $method, $params) {
		$sdk = new PecomKabinet(self::LOGIN, self::KEY);
		$result = $sdk->call($group, $method, $params, true);
		$sdk->close();
		// CAkop::pr_var($result);
		return $result;
	}
}
?>