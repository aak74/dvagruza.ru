<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters["PARAMETERS"] = array(
	"SELECTOR" => array(
		// "PARENT" => $key,
		"NAME" => GetMessage("AKOP_PRINT_SELECTOR_SIBLINGS"),
		"DEFAULT" => "#wrap",
	  "TYPE" => "STRING",
  ),
	"PARAM" => array(
		// "PARENT" => $key,
		"NAME" => GetMessage("AKOP_PRINT_PARAM"),
		"DEFAULT" => "u_print=Y",
	  "TYPE" => "STRING",
  ),
);

?>