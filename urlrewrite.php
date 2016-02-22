<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/company/(.*)/#",
		"RULE" => "xml_id=$1",
		"ID" => "",
		"PATH" => "/company/index.php",
	),
	array(
		"CONDITION" => "#^/terminal/(.*)/#",
		"RULE" => "id=$1",
		"ID" => "",
		"PATH" => "/terminal/index.php",
	),
	array(
		"CONDITION" => "#^/city/(.*)/#",
		"RULE" => "id=$1",
		"ID" => "",
		"PATH" => "/city/index.php",
	),
);

?>