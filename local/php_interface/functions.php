<?
/* классы с доп.функциями */
CModule::AddAutoloadClasses(
    '',
    array(
        'PecomKabinet' =>  '/app/classes/pecom/pecom_kabinet.php',
        'CLog' =>  '/app/classes/CLog.php',
        'CAkop' =>  '/app/classes/CAkop.php',
        'CCompany' =>  '/app/classes/CCompany.php',
        'CAnswer' =>  '/app/classes/CAnswer.php',
        'CQuery' =>  '/app/classes/CQuery.php',
        'CCalc' =>  '/app/classes/CCalc.php',
        'CCity' =>  '/app/classes/CCity.php',
        'CCityComp' =>  '/app/classes/CCityComp.php',
        'CCityAll' =>  '/app/classes/CCityAll.php',
        'CTerminal' =>  '/app/classes/CTerminal.php',
        'CBranch' =>  '/app/classes/CBranch.php',
        'CPecom' =>  '/app/classes/CPecom.php',
        'CDellin' =>  '/app/classes/CDellin.php',
        'CTkkit' =>  '/app/classes/CTkkit.php',
        'CUpdater' =>  '/app/classes/CUpdater.php',
        'CHLReference' =>  '/app/classes/CHLReference.php',
    )
);

spl_autoload_register(function ($class) {
    include $_SERVER["DOCUMENT_ROOT"] . "/app/classes/" . $class . ".php";
});


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