<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CBranch extends CHLReference{
	const 
		ID = 3;

  public function __construct() {
    parent::__construct(self::ID);
  }

}
?>