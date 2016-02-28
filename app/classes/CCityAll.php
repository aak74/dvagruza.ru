<?
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

class CCityAll extends CHLReference{
	const 
		ID = 8;

  public function __construct() {
    parent::__construct(self::ID);
  }
}
?>