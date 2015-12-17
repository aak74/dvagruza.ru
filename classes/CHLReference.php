<?

CModule::includeModule('highloadblock');

use Bitrix\Highloadblock as HL;

/**
 * @author Андрей Копылов aakopylov@mail.ru
 */
class CHLReference {
	private $entity;

  public function __construct($hlblock) {
		$hldata = HL\HighloadBlockTable::getById($hlblock)->fetch();
		$this->entity = HL\HighloadBlockTable::compileEntity($hldata);
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



}

?>
