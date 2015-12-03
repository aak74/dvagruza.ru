<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?$APPLICATION->ShowTitle()?></title>
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico" />
	
	<link href="<?=SITE_TEMPLATE_PATH?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/common.css" />
	
	<?$APPLICATION->ShowHead();?>
	
	<!--[if lte IE 6]>
	<style type="text/css">
		
		#support-question { 
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/question.png', sizingMethod = 'crop'); 
		}
		
		#support-question { left: -9px;}
		
		#banner-overlay {
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='./images/overlay.png', sizingMethod = 'crop');
		}
		
	</style>
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/colors.css" />
	 <!-- Bootstrap -->

<script src="<?=SITE_TEMPLATE_PATH?>/bootstrap/js/bootstrap.min.js"></script>
		
</head>
<body>
		<div id="page-wrapper" class="container11">
		
			<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	
			<div id="header-container" class="container11">
			<div id="header">
				<div class="logo">
					<a href="<?=SITE_DIR?>" title="<?=GetMessage("HDR_GOTO_MAIN")?>"><?$APPLICATION->IncludeFile(
						SITE_DIR."include/company_name.php",
						Array(),
						Array("MODE"=>"html")
						);?></a>
				</div>
				<div id="header-top">
					<div id="slogan"><?$APPLICATION->IncludeFile(
								SITE_DIR."include/company_slogan.php",
								Array(),
								Array("MODE"=>"html")
							);?>
					</div>
					<div id="contacts">
						<div id="telephone"><nobr><?$APPLICATION->IncludeFile(
								SITE_DIR."include/phone.php",
								Array(),
								Array("MODE"=>"html")
							);?></nobr>
						</div>
						<div id="support">
							<div id="support-question"></div>
							<div id="support-text"><a href="<?=SITE_DIR?>contacts/feedback.php"><?=GetMessage("HDR_ASK")?></a></div>	
						</div>
					</div>
					
					<div id="schedule" class="clearfix">
					<?$APPLICATION->IncludeFile(
								SITE_DIR."include/schedule.php",
								Array(),
								Array("MODE"=>"html")
							);?>
					</div>
				<div class="clearfix"></div>


				<div class="top-menu">
					<?$APPLICATION->IncludeComponent("bitrix:menu", "top-simple", Array(
	"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
	"MENU_CACHE_TYPE" => "Y",	// Тип кеширования
	"MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
	"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	),
	false
);?>
				</div>			
			</div>
		</div>
		</div>
	<div class="clearfix"></div>

				
		
			<div id="content-wrapper" class="container">
				<div id="sidebar" class="col-md-3">
					<div id="sidebar-inner">
					
						

					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						".default",
						Array(
							"AREA_FILE_SHOW" => "page", 
							"AREA_FILE_SUFFIX" => "inc", 
							"AREA_FILE_RECURSIVE" => "N", 
							"EDIT_MODE" => "html", 
							"EDIT_TEMPLATE" => "page_inc.php" 
							)
					);?><?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						".default",
						Array(
							"AREA_FILE_SHOW" => "sect", 
							"AREA_FILE_SUFFIX" => "inc", 
							"AREA_FILE_RECURSIVE" => "Y", 
							"EDIT_MODE" => "html", 
							"EDIT_TEMPLATE" => "sect_inc.php" 
						)
					);?>
					</div>
				</div>
				<div id="content" class="col-md-3">
					<div id="workarea-wrapper" class="container">
						<div id="left-menu" class="col-md-9">
						<?$APPLICATION->IncludeComponent("bitrix:menu", "tree", array(
	"ROOT_MENU_TYPE" => "leftfirst",
	"MENU_CACHE_TYPE" => "Y",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "Y",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "4",
	"CHILD_MENU_TYPE" => "left",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
						</div>						
						<div id="workarea" class="col-md-9">
							<div id="breadcrumb">
							<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
								"START_FROM" => "1",
								"PATH" => "",
								"SITE_ID" => SITE_ID
								),
								false
							);?>
							</div>					
							<div id="workarea-inner">
								<h5><?$APPLICATION->ShowTitle(false);?></h5> 

