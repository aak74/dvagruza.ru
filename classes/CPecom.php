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
			$from = $this->_getCityId( $params["from"] );
			$to = $this->_getCityId( $params["to"] );

			CAkop::pr_var($params, '$params');
			$p = array(
			 "senderCityId" => $from,
			 "receiverCityId" => $to,
			 "Cargos" => array(
			 	array(
					// "length"=> 2, // для авиа перевозок обязательно
					// "width"=> 1, // для авиа перевозок обязательно
					// "height"=> 1, // для авиа перевозок обязательно
					"volume" => $params["volume"],
					"weight" => $params["weight"],
				))
			);
			
			CAkop::pr_var($p, '$params');
			$res = $this->_call('calculator', 'calculateprice', $p);

		CAkop::pr_var($res, '$res');

		    if ( is_array($res) ) {
		        $result = array(
		          "price" => $res["transfers"][0]["costTotal"],
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
		CAkop::pr_var($result, '$result');
	    return $result;
	}
	
	/* Выдает терминалы компании. Внутри каждого города есть массив cities городов, в которые осуществляется доставка */
	public function getCities() {
	}

	public function updateTerminals() {
		$list = $this->getTerminals();

		$city = new CCity();
		$terminal = new CTerminal();

		foreach ($list["branches"] as $item) {
			$name = $item["title"];
			// ищем город
			$cItem = $city->getItem(array("UF_NAME_SHORT" => $name));
			$cityId = $cItem["ID"];

			// добавляем терминал
			$filter = array(
				"UF_XML_ID" => $item["bitrixId"],
				"UF_COMP_ID" => self::COMPANY_ID,
			);

			$params = array(
				"UF_NAME" => $name,
				"UF_COMP_ID" => self::COMPANY_ID,
				"UF_CITY_ID" => $cItem["ID"],
				"UF_ADDRESS" => $item["address"],
				// "UF_PHONES" => $item[""],
				"UF_ZIP" => $item["postalCode"],
				"UF_XML_ID" => $item["bitrixId"],
				// "UF_LONGITUDE" => $item[""],
				// "UF_LATITUDE" => $item[""],
			);

			$id = $terminal->updateEx($filter, $params);
			// если город найден и он неактивен, то нужно добавить ему активность
			if ( $cItem["ID"] && ($cItem["UF_ACTIVE"] == false) ) {
				$city->setActive($cItem["ID"]);
				
			}

		}

	}

	public function getTerminals() {
		return $this->_call('branches', 'all', null);
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