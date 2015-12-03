<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка 404 - Cтраница не найдена");
$site = CSite::GetByID(SITE_ID)->Fetch();

$APPLICATION->SetTitle($site["SITE_NAME"] . " | " . $APPLICATION->GetTitle());
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
