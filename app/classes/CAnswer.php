<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CAnswer extends CHLReference{
	const 
		ID = 5;
	private 
		$xmlId = false,
		$item = false;

	public function __construct($xmlId) {
		parent::__construct(self::ID);
		$this->xmlId = $xmlId;
	}
	

}
?>