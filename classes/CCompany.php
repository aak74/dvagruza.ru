<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCompany extends CHLReference{
	const 
		ID = 2;
	private 
		$xmlId = false,
		$item = false;

	public function __construct($xmlId) {
		parent::__construct(self::ID);
		$this->xmlId = $xmlId;
	}
	
	public function getField($field) {
		if (!$this->item) {
			$this->item = $this->getItem(array('UF_XML_ID' => $this->xmlId));
		}
		return $this->item[$field];
	}

}
?>