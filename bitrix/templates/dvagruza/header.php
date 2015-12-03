<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?//$APPLICATION->ShowMeta("keywords")?>
	<?//$APPLICATION->ShowMeta("description")?>
	<title><?$APPLICATION->ShowTitle()?></title>
	<link rel="shortcut icon" type="image/x-icon" href="/images/favicon2.png" />
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/bootstrap/css/bootstrap.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
<?
/*	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3/js/bootstrap.min.js"></script>*/
$APPLICATION->ShowHead();
?>
</head>
<body>
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<div id="workarea-inner" class="container">
	<h1 class="title"><?$APPLICATION->ShowTitle();?></h1> 

