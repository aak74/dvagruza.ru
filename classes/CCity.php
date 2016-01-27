<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCity extends CHLReference {
	const 
		ID = 6,
		CACHE_PATH = "hlref/city/";

	public function __construct() {
		parent::__construct(self::ID);
		$this->arCache = array(
			"listActive" => array(
				"path" => self::CACHE_PATH . 'listActive/',
				"id" => "not_full"
			),
			"listActiveFull" => array(
				"path" => self::CACHE_PATH . 'listActive/',
				"id" => "full"
			),
			"terminals" => array(
				"path" => self::CACHE_PATH . 'terminals/',
				"id" => "none"
			),
			// "cachePeriod" => 0
			"cachePeriod" => 7200
		);
	}

	/* Возвращает активные города
	 * @isFull = true
	 * При установке данного параметра в true будет возвращен массив с терминалами в данном городе
	 */
	public function getListActive($isFull = false) {
		$cachePath = ( $isFull ? "listActiveFull" : "listActive" );
		$cache = $this->_createCacheInstance( $cachePath );
		if ( $this->_isCacheExists( $cachePath ) ) {
			$result = $cache->GetVars();
			// echo "read from cache";
		} else {
			$result = $this->getList(
				array("UF_NAME_SHORT" => "ASC"),
				array("UF_ACTIVE" => 1),
				array("UF_NAME_SHORT")
			);

			if ( $isFull ) {
				foreach ($result as $key => $value) {
					$result[$key]["TERMINALS"] = $this->getTerminals($value["ID"]);
				}
			}

			// echo "save to cache";

			$this->_saveCache(
				$cache,
				$result
			 );
		}

		return $result;
	}

	// Возвращает список терминалов в городе
	public function getTerminals($id) {
		$cachePath = "terminals" . $id;
		// Создаем новуб запись для возможности кэширования
		$this->arCache[$cachePath] = $this->arCache["terminals"];
		$this->arCache[$cachePath]["id"] = $id;

		$cache = $this->_createCacheInstance( $cachePath );
		if ( $this->_isCacheExists( $cachePath ) ) {
			$result = $cache->GetVars();
			// echo "read from cache";
		} else {
			// Получаем список всех компаний. Нас интересуют ID и названия компаний
			$company = new CCompany();
			$companies = $company->getList(array("UF_NAME" => "ASC"), array(), array("UF_NAME", "UF_XML_ID"));		
			
			// Получаем список терминалов в городе
			$terminal = new CTerminal();
			$terminals = $terminal->getListInCity($id);
			// CAkop::pr_var($terminals, '$terminals');
			foreach ($terminals as $key => $value) {
				$result[] = array(
					"ID" =>  $value["ID"],
					"COMPANY_NAME" =>  $companies[ $value["UF_COMP_ID"] ]["UF_NAME"],
					"COMPANY_XML_ID" =>  $companies[ $value["UF_COMP_ID"] ]["UF_XML_ID"],
					"NAME" =>  $value["UF_NAME"],
				);
			}

			// echo "save to cache";

			$this->_saveCache(
				$cache,
				$result
			);
		}
		return $result;
	}

	// Возвращает список компаний, у которых есть терминалы в данном городе
	public function getCompaniesInCity($id) {
		if (!$id) {
			$result = false;
		} else {
			$terminal = new CTerminal();
			$list = $terminal->getList(
				array("UF_COMP_ID" => "ASC"),
				array("UF_CITY_ID" => $id),
				array("UF_COMP_ID", "UF_NAME")
			);
			// CAkop::pr_var($list, 'list');
			foreach ($list as $value) {
				$result[$value["UF_COMP_ID"]] = $value["UF_COMP_ID"];
			}
		}

		return $result;
		// return array_keys($result);
	}
	
	// Устанавливает признак активности у города
	public function setActive($id) {
		$this->update($id, array("UF_ACTIVE" => 1));
	}
}
?>