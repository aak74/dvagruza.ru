<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCompany extends CHLReference{
	const 
		ID = 2,
		CACHE_PATH = "hlref/company/";
	private 
		$xmlId = false,
		$item = false;

	public function __construct($xmlId) {
		parent::__construct(self::ID);
		$this->xmlId = $xmlId;
		$this->arCache = array(
			"cities" => array(
				"path" => self::CACHE_PATH . 'cities/',
				"id" => $xmlId
			),
			"terminals" => array(
				"path" => self::CACHE_PATH . 'terminals/',
				"id" => $xmlId
			),
			// "cachePeriod" => 0
			"cachePeriod" => 7200
		);

	}
	
	public function getField($field) {
		if (!$this->item) {
			$this->item = $this->getItem(array('UF_XML_ID' => $this->xmlId));
		}
		return $this->item[$field];
	}

	/* Возвращает список городов с терминалами компании.
	 * Терминалы сгруппированы по городам.
	 */
	public function getCities() {
		$cachePath = "cities";
		$cache = $this->_createCacheInstance( $cachePath );
		if ( $this->_isCacheExists( $cachePath ) ) {
			$result = $cache->GetVars();
			// echo "read from cache CITIES";
		} else {
			$list = $this->getTerminals();

			// CAkop::pr_var($list, 'list');
			foreach ($list as $key => $value) {
				$result[ $value["UF_CITY_ID"] ]["TERMINALS"][ $value["ID"] ] = $value;
			}

			$cities = new CCity();
			$list = $cities->getList(
				array(), 
				array("ID" => array_keys($result)) 
			);

			foreach ($list as $key => $value) {
				$result[ $value["ID"] ]["NAME"] = $value["UF_NAME_SHORT"];
				$result[ $value["ID"] ]["ID"] = $value["ID"];
			}

			// echo "save to cache CITIES";
			$this->_saveCache(
				$cache,
				$result
			 );
		}
		return $result;
	}

	/* Возвращает список городов с терминалами компании. */
	public function getTerminals() {
		$cachePath = "terminals";
		$cache = $this->_createCacheInstance( $cachePath );
		if ( $this->_isCacheExists( $cachePath ) ) {
			$result = $cache->GetVars();
			// echo "read from cache TERMINALS";
		} else {
			$terminal = new CTerminal();
			$result = $terminal->getList( 
				array("UF_NAME" => "ASC"), 
				array("UF_COMP_ID" => $this->getField("ID"))
			);

			// echo "save to cache TERMINALS";
			$this->_saveCache(
				$cache,
				$result
			 );
		}
		return $result;

	}

}
?>