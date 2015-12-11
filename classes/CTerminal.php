<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CTerminal extends CHLReference{
	const 
		ID = 7;

  public function __construct() {
    parent::__construct(self::ID);
  }

}
?>