<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCityComp extends CHLReference{
	const 
		ID = 9;

  public function __construct() {
    parent::__construct(self::ID);
  }

}
?>