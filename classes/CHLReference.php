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

	function getList($order = array(), $filter = array()) {
		$entityDataClass = $this->entity->getDataClass();
		$arParams = array(
			'order' => $order,
			'filter' => $filter
		);
		$res = $entityDataClass::getList($arParams);

		while ($el = $res->Fetch()) {
			$result[$el["ID"]] = $el;
		}
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
