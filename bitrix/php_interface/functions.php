<?
/* классы с доп.функциями */
CModule::AddAutoloadClasses('',
    array(
    // работа с элементами каталога
    'PecomKabinet' =>  '/classes/pecom/pecom_kabinet.php',
    'CAkop' =>  '/classes/CAkop.php',
    'CCompany' =>  '/classes/CCompany.php',
    'CCalc' =>  '/classes/CCalc.php',
    'CCity' =>  '/classes/CCity.php',
    'CBranch' =>  '/classes/CBranch.php',
    'CPecom' =>  '/classes/CPecom.php',
    'CDellin' =>  '/classes/CDellin.php',
    'CUpdater' =>  '/classes/CUpdater.php',
    'CHLReference' =>  '/classes/CHLReference.php',
  )
);

AddEventHandler('main', 'OnBuildGlobalMenu', 'CustomMenuElements');
function CustomMenuElements(&$aGlobalMenu, &$aModuleMenu){
  $aModuleMenu[] = array(
    "parent_menu" => "global_menu_services",
    "sort" => 2000,
    "text" => "Управление городами",
    "title" => "Управление городами",
    "url" => "admin_cities.php",
    "more_url" => array(),
    "icon" => "",
    "page_icon" => "",
  );
}
?>