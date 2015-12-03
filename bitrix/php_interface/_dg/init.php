<?
/* Для предотвращения загрузки init.php в url необходимо указать параметр aa74ko=stop
 * На период сессии init.php подгружаться не будет.
 * Для обратного включения необходимо указать aa74ko=N
 */
session_start();
if (isset($_GET['aa74ko']) && !empty($_GET['aa74ko'])) {
    $strNoInit = strval($_GET['aa74ko']);
    if ($strNoInit == 'N') {
        if (isset($_SESSION['NO_INIT']))
        unset($_SESSION['NO_INIT']);
    } elseif ($strNoInit == 'stop') {
      $_SESSION['NO_INIT'] = 'Y';
    }
}

if (!(isset($_SESSION['NO_INIT']) && $_SESSION['NO_INIT'] == 'Y')) {
    $initName = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/" . SITE_ID . "/functions.php";
    if (file_exists($initName)) {
        require_once($initName);
    }  
}

?>