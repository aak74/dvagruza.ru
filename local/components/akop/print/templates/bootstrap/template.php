<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

CJSCore::Init(array("jquery"));
?>
<a href="<?=$APPLICATION->GetCurPageParam("u_print=Y")?>" target="_blank" class="icon-top-menu navbar-right" title="<?=GetMessage("AKOP_PRINT_PRINT")?>"><span class="glyphicon glyphicon-print icon-lg"></span></a>