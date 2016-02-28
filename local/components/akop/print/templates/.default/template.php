<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

CJSCore::Init(array("jquery"));
?>
<a href="<?=$APPLICATION->GetCurPageParam("u_print=Y")?>" target="_blank" title="<?=GetMessage("AKOP_PRINT_PRINT")?>"><?=GetMessage("AKOP_PRINT_PRINT")?></a>