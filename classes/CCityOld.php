<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCity extends CHLReference{
	const 
		ID = 1;

  public function __construct() {
    parent::__construct(self::ID);
  }

  public function getListMain() {
  	return $this->getList(array("UF_NAME" => "asc"), array("!UF_NAME" => false, "UF_PARENT" => false));
  }

  public function getListChildren($parentId) {
  	return $this->getList(array("UF_NAME" => "asc"), array("!UF_NAME" => false, "UF_PARENT" => $parentId));
  }

  public function getCompaniesInCity($id) {
    if (!$id) {
      $result = false;
    } else {
      $branches = new CBranch();
      $list[$id] = $id;
      // Получаем список дублирующихся городов
      $children = $this->getListChildren($id);
      foreach ($children as $key => $value) {
        $list[$key] = $key;
      }
      unset($children);
      foreach ($list as $value) {
        $br[] = $branches->getList(array(), array("UF_CITY_ID" => $value));
      }
      unset($branches);
      foreach ($br as $key => $value) {
        foreach ($value as $branch) {
          $result[$branch["UF_COMP_ID"]] = $branch["UF_COMP_ID"];
        }
      }
    }

    return $result;
  }
  
  public function setParent($ids, $parentId) {
  	if ( is_array($ids) ) {
  		foreach ($ids as $id) {
  			$this->_setParent($id, $parentId);
  		}
  	} else {
			$this->_setParent($ids, $parentId);
  	}
  	return true;
  }

  private function _setParent($id, $parentId) {
  	echo $id, "--", $parentId, "<br>";
  	$this->update($id, array("UF_PARENT" => $parentId));
  }
}
?>