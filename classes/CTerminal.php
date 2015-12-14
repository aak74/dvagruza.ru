<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CTerminal extends CHLReference{
	const 
		ID = 7;

	public function __construct() {
		parent::__construct(self::ID);
	}

	public function getListInCity($cityId, $companyId = false) {
		// echo '$cityId = ', $cityId, "__";
		$filter["UF_CITY_ID"] = $cityId;
		if ($companyId) {
			$filter["UF_COMP_ID"] = $companyId;
		}
		$result = $this->getList( 
			array("UF_COMP_ID" => "ASC", "UF_NAME" => "ASC"), 
			$filter,
			array("UF_NAME", "UF_COMP_ID")
		);
		/*
		foreach ($res as $value) {
			// $result[$value["ID"]] = array(
			$result[] = array(
				"id" => $value["ID"],
				"name" => $value["UF_NAME"],
				"comp_id" => $value["UF_COMP_ID"]
			);
		}
		*/
		return $result;
	}


}
?>