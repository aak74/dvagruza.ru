<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCity extends CHLReference {
	const 
		ID = 6;

	public function __construct() {
		parent::__construct(self::ID);
	}

	// Возвращает активные города
	public function getListActive() {
		return $this->getList(
			array("UF_NAME_SHORT" => "ASC"),
			array("UF_ACTIVE" => 1),
			array("UF_NAME_SHORT")
		);
	}

	// Возвращает список терминалов в городе
	public function getListTerminals($id) {
		// Получаем список всех компаний. Нас интересуют ID и названия компаний
		$company = new CCompany();
		$companies = $company->getList(array("UF_NAME" => "ASC"), array(), array("UF_NAME"));		
		
		// Получаем список терминалов в городе
		$terminal = new CTerminal();
		$terminals = $terminal->getListInCity($id);
		// CAkop::pr_var($terminals, '$terminals');
		foreach ($terminals as $key => $value) {
			$result[] = array(
				"ID" =>  $value["ID"],
				"COMPANY_NAME" =>  $companies[ $value["UF_COMP_ID"] ]["UF_NAME"],
				"NAME" =>  $value["UF_NAME"],
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