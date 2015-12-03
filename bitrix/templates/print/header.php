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
	<link href="<?=SITE_TEMPLATE_PATH?>/bootstrap/css/bootstrap-theme.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/common.css" />
	
	<?$APPLICATION->ShowHead();?>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/colors.css" />

</head>
<body>
	<?$APPLICATION->ShowPanel();?>
	<div id="workarea-inner">
		<h1><?$APPLICATION->ShowTitle(false);?></h1> 