<?
/* классы с доп.функциями */
CModule::AddAutoloadClasses('',
    array(
    // работа с элементами каталога
    'PecomKabinet' =>  '/classes/pecom/pecom_kabinet.php',
    'CAkop' =>  '/classes/CAkop.php',
    'CCompany' =>  '/classes/CCompany.php',
    'CAnswer' =>  '/classes/CAnswer.php',
    'CQuery' =>  '/classes/CQuery.php',
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
AddEventHandler("main", "OnEpilog", "setTitle");

function setTitle() {
    if (SITE_ID == "dg") {
        global $APPLICATION;
        $APPLICATION->SetPageProperty('title', "Два груза | " . $APPLICATION->GetTitle());
    }
}

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

spl_autoload_register(function ($class) {
    include $_SERVER["DOCUMENT_ROOT"] . "/classes/" . $class . ".php";
});


AddEventHandler("api.feedback", "OnBeforeEmailSend", "OnBeforeEmailSendHandler");

function OnBeforeEmailSendHandler(&$event_name, &$site_id, &$arFields, &$message_id) {
    
    CModule::IncludeModule('iblock'); 

        $el = new CIBlockElement;
        $elem_id = $el->Add(array(
            "IBLOCK_ID" => 6,
            "NAME" => $arFields["AUTHOR_NAME"],
            "DETAIL_TEXT" => $arFields["AUTHOR_MESSAGE"],
            "PROPERTY_VALUES" => array(
                "NAME" => $arFields["AUTHOR_NAME"],
                "EMAIL" => $arFields["AUTHOR_EMAIL"],
                "PHONE" => $arFields["AUTHOR_PERSONAL_MOBILE"]
            ),
        ));

    return true;
}


?>