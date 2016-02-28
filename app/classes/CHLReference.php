<?

CModule::includeModule('highloadblock');

use \Bitrix\Main\Data\cache;
use \Bitrix\Highloadblock as HL;

/**
 * @author Андрей Копылов aakopylov@mail.ru
 */
class CHLReference {
	private $entity;
	protected $arCache = array();

  public function __construct($hlblock) {
		$hldata = HL\HighloadBlockTable::getById($hlblock)->fetch();
		$this->entity = HL\HighloadBlockTable::compileEntity($hldata);
		$this->arCache = array(
			"cachePeriod" => 7200
		);
		return $this;
  }
	
	function getItem($filter = array()) {
		$result = $this->getList(array(), $filter);
		if (is_array($result)) {
			$result = current($result);
		} else {
			$result = false;
		}
		return $result;
	}

	function getList( $order = array(), $filter = array(), $select = array("*") ) {
		// обрабатываем переданный false в качестве фильтра
		$filter = ( ( empty($filter) ) ? array() : $filter );
		// Обязательно добавляем ID к выводу. В противном случае будет выведен только один элемент.
		if ( !empty($select) && !isset($select["ID"]) ) {
			$select[] = "ID";
		}

		$entityDataClass = $this->entity->getDataClass();
		$arParams = array(
			'order' => $order,
			'filter' => $filter,
			'select' => $select
		);
		$res = $entityDataClass::getList($arParams);

		while ($el = $res->Fetch()) {
			$result[$el["ID"]] = $el;
		}

		// CAkop::pr_var(array(
		// 	"filter" => $filter,
		// 	"result" => $result
		// ));
		return $result;
	}


	function add($params) {
		$entityDataClass = $this->entity->getDataClass();
	  
	  $result = $entityDataClass::add($params);
	  $id = $result->getId();
	  // if($result->isSuccess())
	  return $id;
	}

	function update($id, $params) {
		$entityDataClass = $this->entity->getDataClass();
	  
	  $result = $entityDataClass::update($id, $params);
	  return $id;
	}

	/* Добавляем данные или обновляем их */
	function updateEx($filter, $params) {
		if ($item = $this->getItem($filter)) {
			$id = $item["ID"];
			$this->update($id, $params);
		} else {
			$id = $this->add($params);
		}
	  return $id;
	}

	/* Создаем Instance кэша при установленном периоде кэширования и наличии в параметрах пути и ид кэша */
	protected function _createCacheInstance($id) {
		$this->arCache[$id]["exists"] = false;
		if ( ( $this->arCache["cachePeriod"] > 0 ) 
				&& isset( $this->arCache[$id] )
				&& is_array( $this->arCache[$id] ) 
				&& isset( $this->arCache[$id]["id"] )
				&& isset( $this->arCache[$id]["path"] )
				) {

			$cache = cache::createInstance();
			$this->arCache[$id]["exists"] = $cache->initCache( 
				$this->arCache["cachePeriod"], 
				$this->arCache[$id]["id"], 
				$this->arCache[$id]["path"] 
			);

			$result = $cache;
		} else {
			$result = false;
		}
		return $result;
	}

	/* сохраняем данные в кэш при установленном периоде кэширования */
	protected function _saveCache($cache, $vars) {
		// CAkop::pr_var($this->arCache, 'this->arCache');
		if ( ( $this->arCache["cachePeriod"] > 0 ) && $cache && $vars ) {
			$cache->startDataCache();
			$cache->endDataCache($vars);
			$result = true;
		} else {
			$result = false;
		}
		return $result;
	}

	protected function _isCacheExists($id) {
		if ( isset( $this->arCache[$id] )
			&& is_array( $this->arCache[$id] ) 
			&& isset( $this->arCache[$id]["exists"] )
			) {
			$result = $this->arCache[$id]["exists"];
		} else {
			$result = false;
		}

		return $result;
	}

}

?>
