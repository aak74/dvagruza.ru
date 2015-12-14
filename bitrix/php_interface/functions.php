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
    'CCityComp' =>  '/classes/CCityComp.php',
    'CCityAll' =>  '/classes/CCityAll.php',
    'CTerminal' =>  '/classes/CTerminal.php',
    'CBranch' =>  '/classes/CBranch.php',
    'CPecom' =>  '/classes/CPecom.php',
    'CDellin' =>  '/classes/CDellin.php',
    'CTkkit' =>  '/classes/CTkkit.php',
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
    "url" => "city_admin.php",
    "more_url" => array(),
    "icon" => "",
    "page_icon" => "",
  );
}
?>